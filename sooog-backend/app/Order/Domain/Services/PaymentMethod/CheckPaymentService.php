<?php

namespace App\Order\Domain\Services\PaymentMethod;

use App\Admin\Domain\Models\Admin;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Helpers\MyFatoorah;
use App\Infrastructure\Helpers\Payment\PaymentService;
use App\Notification\Domain\Notifications\OrderNotification;
use App\Order\Domain\Models\Cart;
use App\Order\Domain\Models\Order;
use App\Order\Domain\Resources\OrderResource;
use App\Package\Domain\Models\StorePackage;
use App\Package\Domain\Resources\StorePackageResource;
use App\Store\Domain\Models\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckPaymentService extends Service
{
    public $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function handle($data = [])
    {
        $res = $this->paymentService->checkPayment($data);
        $lang = app()->getLocale();
        $baseUrl = $res['route'];
        switch ($res['for']) {
            case 'order':
                if ($res['status'] != 200 || $res['paid'] != true) {
                    $error = $res['msg'];
                    if ($res['additional_info'] == 'web') {
                        return new GenericPayload([
                            'error' => $error,
                            'route' => "$baseUrl/$lang/carts"
                        ], Response::HTTP_ACCEPTED);
                    } else {
                        return new GenericPayload([
                            'error' => $error,
                            'route' => route('payment-error')
                        ], Response::HTTP_ACCEPTED);
                    }
                } else {
                    $order = Order::withoutGlobalScopes()->findOrFail($res['order_id']);
                    DB::beginTransaction();
                    $updatedData['is_paid'] = 1;
                    if (isset($res['brand'])) {
                        $updatedData['payment_method_brand'] = $res['brand'];
                    }
                    $order->update($updatedData);
                    if ($order->type == 'stores') {
                        Cart::where('user_id', $order->user_id)->delete();
                        $route = "$baseUrl/$lang/orders";
                    } else {
                        $route = "$baseUrl/$lang/orders/services";
                    }
                    if ($order->wallet_payout != 0.00) {
                        $order->user->transactions()->create([
                            'type' => 'pay_out',
                            'amount' => $order->wallet_payout,
                            'wallet_total' => 0.00,
                            'transactable_id' => $order->id,
                            'transactable_type' => 'App\Order\Domain\Models\Order',
                            //'reason' => 'order',
                            'ar' => ['reasons' => "تم استخدام مبلغ  {$order->wallet_payout} من الحفظة لاستخدامها فى الطلب  رقم {$order->id}"],
                            'en' => ['reasons' => "{$order->wallet_payout} has been used from your wallet for order no. {$order->id}"],

                        ]);
                    }
                    DB::commit();
                    $msg = __('success.orders.sentSuccesffuly') . ' ' . $order->id;
                    $admin = Admin::whereIsActive(1)->first();
                    $notif_data = array(
                        'ar' => ['title' => 'طلب جديد', 'body' => 'تم اضافة طلب جديد ورقم الطلب ه ' . $order->id],
                        'en' => ['title' => 'new order', 'body' => 'order No.' . $order->id . 'has been added'],
                    );
                    $admin->notify(new OrderNotification($order, $notif_data));
                    //$user->notify(new OrderNotification($order, $msg));
                    send_fcm_notification(
                        $admin,
                        [
                            "title" => __('general.orders.newOrder'),
                            "body" => $msg,
                            "type" => 'order',
                            "model_id" => $order->id
                        ],
                        true
                    );
                    // return new GenericPayload(['message' => __('success.orders.sentSuccesffuly'). ' '. $order->id]);
//            return redirect(route('payment-success'));
                    if ($res['additional_info'] == 'web') {
                        return new GenericPayload(
                            [
                                'message' => $msg,
//                    'route' => 'payment-success',
                                'route' => $route,
                                'order' => new OrderResource($order),
                            ],
                            Response::HTTP_ACCEPTED
                        );
                    } else {
                        return new GenericPayload(
                            [
                                'message' => $msg,
                                'route' => route('payment-success'),
//                        'route' => $route,
                                'order' => new OrderResource($order),
                            ],
                            Response::HTTP_ACCEPTED
                        );
                    }
                }
            case 'package':
                $port = '3056';
                if ($res['status'] != 200 || $res['paid'] != true) {
                    $order = StorePackage::withoutGlobalScopes()->findOrFail($res['order_id']);
                    $store = Store::withoutGlobalScopes()->findOrFail($order->store_id);
                    if ($store->status == 0) {
                        $route = "$baseUrl/$lang/stores/auth/register";
                    } else {
                        $route = "$baseUrl
                       :$port
                        /$lang/stores/packages";
                    }

                    $error = $res['msg'];
                    if ($res['additional_info'] == 'web') {
                        return new GenericPayload([
                            'error' => $error,
                            'route' => $route
                        ], Response::HTTP_ACCEPTED);
                    } else {
                        return new GenericPayload([
                            'error' => $error,
                            'route' => route('payment-error')
                        ], Response::HTTP_ACCEPTED);
                    }
                } else {
                    $order = StorePackage::withoutGlobalScopes()->findOrFail($res['order_id']);
                    $old_package = StorePackage::active(1)->where('store_id', $order->store_id)->get('id');
                    DB::beginTransaction();
                    $updatedData['is_paid'] = 1;
                    $store = Store::withoutGlobalScopes()->findOrFail($order->store_id);
                    if ($store->status == 0) {
                        $route = "$baseUrl/$lang";
                    } else {
                        $route = "$baseUrl:$port/$lang/stores/packages";
                    }
                    Log::info($route);
                    $store->is_paid = 1;
                    $store->save();
                    if (isset($res['brand'])) {
                        $updatedData['payment_method_brand'] = $res['brand'];
                    }
                    $order->update($updatedData);
                    StorePackage::whereIn('id', $old_package->pluck('id')->toArray())->update(['is_active' => 0]);
                    DB::commit();
                    $msg = __('success.subscribe_package_done');
//                    $admin = Admin::whereIsActive(1)->first();
//                    $notif_data = array(
//                        'ar' => ['title' => 'طلب جديد', 'body' => 'تم اضافة طلب جديد ورقم الطلب ه ' . $order->id],
//                        'en' => ['title' => 'new order', 'body' => 'order No.' . $order->id . 'has been added'],
//                    );
//                    $admin->notify(new OrderNotification($order, $notif_data));
//                    //$user->notify(new OrderNotification($order, $msg));
//                    send_fcm_notification(
//                        $admin,
//                        [
//                            "title" => __('general.orders.newOrder'),
//                            "body" => $msg,
//                            "type" => 'order',
//                            "model_id" => $order->id
//                        ],
//                        true
//                    );
//                    // return new GenericPayload(['message' => __('success.orders.sentSuccesffuly'). ' '. $order->id]);
////            return redirect(route('payment-success'));
                    if ($res['additional_info'] == 'web') {
                        return new GenericPayload(
                            [
                                'message' => $msg,
//                    'route' => 'payment-success',
                                'route' => $route,
                                'package' => new StorePackageResource($order),
                            ],
                            Response::HTTP_ACCEPTED
                        );
                    } else {
                        return new GenericPayload(
                            [
                                'message' => $msg,
                                'route' => route('payment-success'),
//                        'route' => $route,
                                'package' => new StorePackageResource($order),
                            ],
                            Response::HTTP_ACCEPTED
                        );
                    }
                }
        }
    }
}
