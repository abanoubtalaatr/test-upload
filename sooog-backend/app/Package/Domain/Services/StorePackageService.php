<?php

namespace App\Package\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Package\Domain\Models\StorePackage;
use Symfony\Component\HttpFoundation\Response;

class StorePackageService extends Service
{
    public function handle($data = [])
    {
        if(auth()->guard('store')->check() || auth()->guard('center')->check())
            $store_id = auth()->user()->store_id;
        $storePackage=StorePackage::with('store','package')->active(1)->when($store_id,function ($q) use ($store_id) {
            $q->where('store_id', $store_id);
        })->whereDate('expire_at','>=',today())->first();
        return new GenericPayload($storePackage, Response::HTTP_CREATED);

    }
}
