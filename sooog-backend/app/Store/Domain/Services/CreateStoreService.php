<?php

namespace App\Store\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Helpers\Payment\PaymentService;
use App\Package\Domain\Models\Package;
use App\Package\Domain\Models\StorePackage;
use App\Store\Domain\Models\Store;
use App\User\Domain\Models\User;
use Illuminate\Support\Arr;

use Symfony\Component\HttpFoundation\Response;

class CreateStoreService extends Service
{
    public $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function handle($data = [])
    {
        try {
            $data['status'] = 0;
            $data['is_active'] = 0;
            $data['is_paid'] = 0;
            if(auth()->user()->phone??''==$data['phone'] && auth()->user()->email??''==$data['email']){
                if(User::where('phone',$data['phone'])->where('id','!=',auth()->user()->id)->first()){
                    return new GenericPayload( __('error.duplicatePhone'), 422);
                }
                if(User::where('email',$data['email'])->where('id','!=',auth()->user()->id)->first()){
                    return new GenericPayload( __('error.uniqueEmailValidation'), 422);
                }
            }else{
                if(User::where('phone',$data['phone'])->first()){
                    return new GenericPayload( __('error.duplicatePhone'), 422);
                }
                if(User::where('email',$data['email'])->first()){
                    return new GenericPayload( __('error.uniqueEmailValidation'), 422);
                }
            }
            if(str_starts_with($data['phone'], '9660')){
                $data['phone'] = substr($data['phone'],4,20);
                $data['phone'] = '966'.$data['phone'];
            }
            //dd($data['phone']);

            // $check_user_phone = Store::wherePhone($data['phone'])->whereType($data['type'])->first();

            // if($check_user_phone)
            //     return new GenericPayload( __('error.duplicatePhone'), 422);

            // if(auth()->guard('admin')->check()){
            //     $data['status'] = 1;
            //     $data['is_active'] = 1;
            // }
            $store = Store::withoutGlobalScopes()->create($data);
            $package = Package::findOrFail($data['package_id']);
            if($package->is_free==0 && (!isset($data['payment_method_id']) || $data['payment_method_id']=='')){
                return new GenericPayload(__('error.orders.requiredPaymentMethod'), 422);
            }
            $insert=Arr::only($data,['package_id']);
            $insert['days'] = $package->months * 30;
            $insert['store_id'] = $store->id;
            $insert['from'] = today();
            $insert['expire_at'] = today()->addMonths($package->months);
            $insert['price'] = $package->price;
            $insert['product_number'] = $package->product_number;
            $insert['order_number'] = $package->order_number;
            $insert['order_number'] = $package->order_number;
            $insert['has_chat'] = $package->has_chat;
            $insert['is_rfq'] = $package->is_rfq;
            $insert['is_free'] = $package->is_free;
            $insert['is_paid'] = $package->is_free ? 1 : 0;
            $storePackage = StorePackage::create($insert);
            if ($storePackage->price > 0) {
                $payment = $this->paymentService->doPayment($storePackage, $data['payment_method_id'], 'web', 'package');
                return new GenericPayload(
                    [
                        'payment_url' => $this->paymentService->paymentLink($payment),
                    ],
                    Response::HTTP_RESET_CONTENT
                );
            } else {
                $store->is_paid=1;
                $store->update();
                return new GenericPayload($store, Response::HTTP_CREATED);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return new GenericPayload(
                $ex->getMessage(), 422
            );
        } catch (\PDOException $ex){
            return new GenericPayload(
                $ex->getMessage(), 422
            );
        } 
        catch (\Exception $ex) {
            return new GenericPayload(
                $ex->getMessage(), 422
            );
            
        } 
    }
}
