<?php

namespace App\Package\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Helpers\Payment\PaymentService;
use App\Package\Domain\Models\Package;
use App\Package\Domain\Models\StorePackage;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class SubscribePackageService extends Service
{
    public $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function handle($data = [])
    {
        $package = Package::findOrFail($data['package_id']);
        $oldPackage=auth('store')->user()->store->activePackage;
        if($package->is_free==0 && (!isset($data['payment_method_id']) || $data['payment_method_id']=='')){
            return new GenericPayload(__('error.orders.requiredPaymentMethod'), 422);
            }
            $insert=Arr::except($data,['payment_method_id']);
        $insert['days'] = $package->monthes * 30;
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
            $oldPackage->is_active=0;
            $oldPackage->save();
            return new GenericPayload($storePackage, Response::HTTP_CREATED);
        }

    }
}
