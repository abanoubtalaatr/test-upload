<?php

namespace App\Refund\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Order\Domain\Models\Order;
use App\Refund\Domain\Models\Refund;
use App\Order\Domain\Models\Status;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use DB;
use App\Notification\Domain\Notifications\OrderNotification;
use App\Admin\Domain\Models\Admin;
use App\PromoCode\Domain\Models\PromoCode;
use Symfony\Component\HttpFoundation\Response;
class RefundOrderService extends Service
{
    public function handle($data = []) 
    {
       try {
            // Begin Transaction
            DB::beginTransaction();
            $user = auth()->user();
            $order = Order::findOrFail($data['order_id']);
            $setting = setting('refund_period');
            $refund_period = $setting ? : 10;
            $to = \Carbon\Carbon::now();
            $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $order->created_at);
            $diff_in_days = $to->diffInDays($from);
            // if($order->status->key != 'accepted' && $order->status->key != 'delivered'&& $diff_in_days <= $refund_period && $order->refund != null)
            if($order->type != 'stores' && $order->status->key != 'delivered' || $diff_in_days > $refund_period || $order->refund != null){
                return new GenericPayload(__('error.orders.canotRefund'), 422);
            }

            $data['order_id'] = $order->id;
            $status = Status::where('type', 'refund')->where('key', 'new')->firstOrFail();
            $data['status_id'] = $status->id;

            if($order->user_id != auth()->id() && optional($order->gift)->user_id != auth()->id() && !auth()->check('admin'))
                return new GenericPayload(__('error.orders.userNotOrderOwner'), 422);
            $refund = Refund::whereOrderId($order->id)->first();
            if($refund)
                return new GenericPayload(__('error.orders.refundSentBefore'), 422);

            if($data['refund_type'] == 'order'){
                $data['subtotal'] = $order->subtotal;
                $data['promo_code_discount'] = $order->promo_code_discount;
            }

            $data['created_by'] = auth()->id();
            $data['subtotal'] = 0.000;
            $data['total'] = 0.000;
            $data['promo_code_discount'] = 0.000;
            $refund = Refund::create($data);
            $subtotal = 0.00;
            $has_coupon_total = 0.00;
            $coupon_discount = 0.00;
            $coupon = PromoCode::find($order->promo_code_id);
            if($data['refund_type'] == 'items'){
                foreach ($data['items'] as $item) {
                    $item_check = $order->orderItems()->where('id', $item['order_item_id'])->first();
                    if(!$item_check){
                        // Rollback Transaction
                        DB::rollback();
                        return new GenericPayload( __('error.orders.invalidOrderItem'), 422);
                    }
                    if(isset($item['quantity']) && $item_check->quantity < $item['quantity']){
                        // Rollback Transaction
                        DB::rollback();
                        return new GenericPayload( __('error.orders.invalidQuantity'), 422);
                    }
                    
                    $refund_item = $refund->refundItems()->create([
                        'order_item_id' => $item['order_item_id'],
                        'quantity' => isset($item['quantity']) ? $item['quantity'] : $item_check->quantity,
                        'note' => isset($item['note']) ? $item['note'] : null
                    ]);

                    $subtotal += $refund_item->quantity * ($item_check->product_price +$item_check->warranty_price - $item_check->offer_discount);
                }
                if($order->promo_code_discount > 0)
                    $data['promo_code_discount'] = $subtotal * $order->promo_code_discount / $order->total;

                
            } else {
                $subtotal = $order->subtotal;
            }

            $refund->update([
                'subtotal' => $subtotal,
                'promo_code_discount' => $data['promo_code_discount'],
                'total' => $subtotal - $data['promo_code_discount']
            ]);

            auth()->user()->orderStatuses()->firstOrCreate([
                'order_id' => $refund->id,
                'status_id' => $status->id,
                'type' => 'refund',
            ]);

            if($order->user_id != auth()->id()){
                $msg = __('general.orders.refundRequestSent');
                $notification_data = array(
                    'ar' => ['title' => 'طلب استرجاع', 'body' => 'تم طلب استرجاع لطلبك رقم   '. $order->id],
                    'en' => ['title' => 'refund order', 'body' => 'refund has been requested for your order No.'.$order->id],
                );
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
            }

            $admin = Admin::whereIsActive(1)->first();
            $notif_data = array(
                'ar' => ['title' => 'مرتجع جديد', 'body' => 'تم طلب استرجاع للطلب رقم   '. $order->id],
                'en' => ['title' => 'new refund', 'body' => 'refund has been requested for order No.'.$order->id],
            );
            $admin->notify(new OrderNotification($refund->order, $notif_data));

            // Commit Transaction
            DB::commit();
            return new GenericPayload(['message' => __('success.orders.refundSentSuccesfully'). ' '. $refund->order->id], Response::HTTP_RESET_CONTENT);            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            // Rollback Transaction
            DB::rollback();
            throw new ModelNotFoundException;
        } 
        catch (\Exception $ex) {
            // Rollback Transaction
            DB::rollback();
            return new GenericPayload(
                $ex->getMessage(), 422
            );
            
        }
    }
}