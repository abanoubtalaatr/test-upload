<?php
/**
 * Created by PhpStorm.
 * User: Ahmed
 * Date: 9/15/2020
 * Time: 2:26 PM
 */

namespace App\Infrastructure\Helpers\Payment;


use App\Infrastructure\Exceptions\ModelNotFoundException;
use App\Order\Domain\Models\OnlinePaymentMethod;
use App\Order\Domain\Models\Order;
use App\Package\Domain\Models\StorePackage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;


class HyperPay implements PaymentService
{

    protected $link;
    protected $token;

    public function __construct()
    {
        if (env('APP_ENV') == 'local') {
            $this->link = env('Test_Payment_link');
            $this->token = env('Test_Access_Token');
        } else {
            $this->link = env('Live_Payment_link');
            $this->token = env('Live_Access_Token');
        }
    }

    public function getIntityId($brand)
    {
        if (env('APP_ENV') == 'local') {
            return env('Test_' . $brand . '_Entity_ID');
        } else {
            return env('Live_' . $brand . '_Entity_ID');
        }
    }

    public function getMethods()
    {
//        Log::info('first='.session('checkout_id'));
        $methods = OnlinePaymentMethod::active(1)->get()->map(function ($tag) {
            return [
                'PaymentMethodId' => $tag->id,
                'PaymentMethodAr' => $tag->translate('ar')->name,
                'PaymentMethodEn' => $tag->translate('en')->name,
                'ImageUrl' => $tag->image,
            ];
        });
        return $methods;

    }

    public function doPayment($order, $payment_method_id, $type = null, $for = 'order')
    {
        $payment_method = OnlinePaymentMethod::active(1)->findOrFail($payment_method_id);
        $brand = in_array($payment_method->index, ['VISA', 'MASTER']) ? 'Default' : $payment_method->index;
        $entityId = $this->getIntityId($brand);
        $url = $this->link . "v1/checkouts";
        $amount =$for=='order'?$order->total:$order->price;
        $amount = env('APP_ENV') == 'local' ? number_format($amount, 2, '.', '') : $amount;

        $email = $for == 'order' ? (auth()->user()->email ?? 'user@user.com') : ($order->store->email ?? 'user@user.com');
        $name = $for == 'order' ? (auth()->user()->name ?? ("user" . auth()->user()->phone)) : ($order->store->name ?? ("user" ));
        $verfiy = env('APP_ENV') == 'local' ? false : true;
        $data = "entityId=" . $entityId .
            "&amount=" . $amount .
            "&currency=SAR" .
//            "&testMode=EXTERNAL" .
            "&paymentType=DB" .
            "&merchantMemo=" . $type .
            "&customParameters['SHOPPER_for']=" . $for .
            "&merchantTransactionId=" . $order->id .
            "&customer.email=" . $email .
            "&customer.givenName=" . $name .
            "&customer.surname=" . $name .
            "&billing.street1= street" .
            "&billing.city= Buraydah" .
            "&billing.state= Qassim" .
            "&billing.postcode=966";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer ' . $this->token));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $verfiy);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $responseData = json_decode($responseData);
        if (!($responseData && $responseData->id)) {
            throw new \Exception('Payment Error');
        }
//        Log::info($data);
        $res['check_id'] = $responseData->id;
        $res['payment_method'] = $payment_method->index;
        $res['payment_method_id'] = $payment_method->id;
        $order->update([
            'transaction_id' => $responseData->id,
            'payment_method_brand' => $payment_method->index,
        ]);
        $res['payment_link'] = route('hyperPay', ['for' => $for, 'order' => Crypt::encrypt($order->id)]);
        return $res;
    }

    public function paymentLink($data)
    {
        return $data['payment_link'];
    }

    public function checkPayment($data, $brand = null)
    {
        try {
            $checkout_id = $data['id'];
            $order = Order::withoutGlobalScopes()->where('transaction_id', $checkout_id)->first();
            if (!$order) {
                $order = StorePackage::withoutGlobalScopes()->where('transaction_id', $checkout_id)->firstOrFail();
            }
            $brand = in_array($order->payment_method_brand, ['VISA', 'MASTER']) ? 'Default' : $order->payment_method_brand;
            $verfiy = env('APP_ENV') == 'local' ? false : true;
            $entityId = $this->getIntityId($brand);
            $url = $this->link . $data['resourcePath'];
            $url .= "?entityId=" . $entityId;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer ' . $this->token));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $verfiy);//TODO this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            $responseData = json_decode($responseData);
//            dd($responseData);
            if (curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            $code = optional($responseData->result)->code ?? null;
            $successCodePattern = '/^(000\.000\.|000\.100\.1|000\.[36])/';
            $successManualReviewCodePattern = '/^(000\.400\.0|000\.400\.100)/';
            //success status
            if (preg_match($successCodePattern, $code) || preg_match($successManualReviewCodePattern, $code)) {
                return [
                    'status' => 200,
                    'paid' => true,
                    'msg' => '',
//                    'route' => 'http://localhost:3000',
                    'route' => 'http://soog.fudex-tech.net',
                    'brand' => $order->payment_method_brand,
                    'order_id' => $responseData->merchantTransactionId,
                    'additional_info' => $responseData->merchantMemo,
                    'for' => $responseData->customParameters->SHOPPER_for,
                ];
            } elseif (!isset($responseData->id)) {
                throw new \Exception('Too Much Time, Try Again', 400);
            } else {
                return [
                    'status' => 400,
                    'paid' => false,
                    'msg' => optional($responseData->result)->description ?? null,
//                    'route' => 'http://localhost:3000',
                    'route' => 'http://soog.fudex-tech.net',
                    'brand' => $order->payment_method_brand,
                    'order_id' => $responseData->merchantTransactionId,
                    'additional_info' => $responseData->merchantMemo,
                    'for' => $responseData->customParameters->SHOPPER_for,
                ];
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            // Rollback Transaction
            throw new ModelNotFoundException();
        }
    }

}
