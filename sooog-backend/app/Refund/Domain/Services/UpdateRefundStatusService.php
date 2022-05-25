<?php

namespace App\Refund\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Refund\Domain\Models\Refund;
use App\Order\Domain\Models\Status;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use App\Notification\Domain\Notifications\OrderNotification;
use App\Order\Domain\Models\Order;
use App\Product\Domain\Models\Product;
use App\Order\Domain\Models\Transaction;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;
use DB;

class UpdateRefundStatusService extends Service
{
    public function handle($data = []) 
    {
         DB::beginTransaction();
        try {

            $refund = Refund::findOrFail($data['refund_id']);
            //$status = Status::findOrFail($data['status_id']);
            $status = Status::whereType('refund')->where('key', $data['status'])->firstOrFail();
            if($status->key == 'rejected' || $status->key == 'accepted' || $status->key == 'replaced'){
                if($refund->status->key != 'new')
                    return new GenericPayload(__('error.orders.cannotChangeStatus'), 422);
            }
            if($status->key == 'rejected'){
                if(!isset($data['reason']))
                    return new GenericPayload(__('error.orders.requiredReason'), 422);
            }
            $refund->update([
                'status_id' => $status->id,
                'reason' => isset($data['reason']) ? $data['reason'] : null
            ]);
            $refund = Refund::findOrFail($data['refund_id']);

            auth()->user()->orderStatuses()->firstOrCreate([
                'order_id' => $refund->id,
                'status_id' => $status->id,
                'type' => 'refund',
            ]);
            //$refund = Refund::findOrFail($data['refund_id']);
            if($refund->status->key == 'accepted'){
                $wallet = optional($refund->order->user->transactions()->orderBy('id', 'desc')->first())->wallet_total ? : 0.00;
                $transaction_amount = 0.00;

                if($refund->refund_type == 'items'){
                    foreach ($refund->refundItems()->get() as $item) {
                        $orderItem = $item->orderItem()->firstOrFail();
                        $product = Product::findOrFail($orderItem->product_id);
                        $product->update([
                            'quantity' => $product->quantity + $item->quantity
                        ]);

                        //$orderItem = $refund->order->orderItems()->where('id', $item['order_item_id'])->firstOrFail();
                        if($orderItem->free_product_id != null){
                            $free_product = Product::findOrFail($orderItem->free_product_id);
                            $free_product->update([
                                'quantity' => ($free_product->quantity + $item->quantity)
                            ]);
                        }
                    }
                    
                }else {
                    foreach ($refund->order->orderItems()->get() as $item) {
                        $product = Product::findOrFail($item->product_id);
                        $product->update([
                            'quantity' => $product->quantity + $item->quantity
                        ]);

                        if($item->free_product_id !== null){
                            $free_product = Product::findOrFail($item->free_product_id);
                            $free_product->update([
                                'quantity' => ($free_product->quantity + $item->quantity)
                            ]);
                        }
                    }
                }

                $transaction_amount = $refund->subtotal - $refund->promo_code_discount;
                if($transaction_amount < 0)
                    $transaction_amount = 0;

                if($transaction_amount > 0){
                    $refund->order->user->transactions()->create([
                        'type' => 'pay_in',
                        'amount' => $transaction_amount,
                        'wallet_total' => $wallet + $transaction_amount,
                        'transactable_id' => $refund->id,
                        'transactable_type' => 'App\Refund\Domain\Models\Refund',
                        //'reason' => 'refund',
                        'ar'  => ['reason' => 'استرجاع  طلب  بقيمة '.$transaction_amount],
                        'en'  => ['reason' => "refund order with amount {$transaction_amount}"],
                    ]);
                }
            }

            switch ($status->key) {
                case 'rejected':
                    $msg = __("success.orders.rejectedOrder"). ' '.$refund->reason;
                    $notification_data = array(
                        'ar' => ['title' => 'طلب استرجاع مرفوض', 'body' => 'تم رفض  طلب الاسترجاع لطلبك رقم   '. $refund->order->id],
                        'en' => ['title' => 'rejected refund order', 'body' => 'the refund request for your order No.'.$refund->order->id. ' has been rejected'],
                    );
                    break;
                case 'accepted':
                    $msg = __('success.orders.acceptedOrder'). ' '.$refund->order->id;
                    $notification_data = array(
                        'ar' => ['title' => 'تم قبول طلب الاسترجاع الخاص بكم', 'body' => 'تم قبول  طلب الاسترجاع لطلبك رقم   '. $refund->order->id],
                        'en' => ['title' => 'Refund request has been accepted', 'body' => 'the refund request for your order No.'.$refund->order->id. ' has been accepted'],
                    );
                    break;
                case 'replaced':
                    $msg = __('success.orders.replacedOrder'). ' '.$refund->order->id;
                    $notification_data = array(
                        'ar' => ['title' => 'طلب استرجاع  تم استبداله', 'body' => 'تم ارسال بديل  لطلبك رقم   '. $refund->order->id],
                        'en' => ['title' => 'replaced refund order', 'body' => 'A replacement has been sent for your order No. '.$refund->order->id],
                    );
                    break;
                default:
                    $msg = __('success.orders.updatedSuccessfully');
                    $notification_data = [];
                    break;
            }

            
            //$refund->order->user->notify(new RefundNotification($refund, $notification_data));
            $refund->order->user->notify(new OrderNotification($refund->order, $notification_data));
            send_fcm_notification(
                $refund->order->user, 
                [
                    "title" => __("general.order_statuses.{$status->key}"),
                    "body" => $msg, 
                    "type" => 'order',
                    "model_id" =>  $refund->order->id
                ]
            );
            if($refund->creator && optional($refund->creator)->id != $refund->order->user->id){
                $refund->creator->notify(new OrderNotification($refund->order, $notification_data));
                send_fcm_notification(
                    $refund->creator, 
                    [
                        "title" => __("general.order_statuses.{$status->key}"),
                        "body" => $msg, 
                        "type" => 'order',
                        "model_id" =>  $refund->order->id
                    ]
                );
            }

            $refund->update([
                'status_id' => $status->id,
                'reason' => isset($data['reason']) ? $data['reason'] : null
            ]);
            DB::commit();
            return new GenericPayload($refund, Response::HTTP_CREATED);
            
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            DB::rollback();
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            DB::rollback();
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
        

    }
}
