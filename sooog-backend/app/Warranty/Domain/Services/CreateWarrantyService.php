<?php

namespace App\Warranty\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Warranty\Domain\Models\Warranty;
use Symfony\Component\HttpFoundation\Response;

class CreateWarrantyService extends Service
{
    public function handle($data = []) 
    {
        if(auth()->guard('store')->check() || auth()->guard('center')->check())
            $data['store_id'] = auth()->user()->store_id;
        $data['is_active'] = isset($data['is_active']) ? $data['is_active'] : 1;
        $warranty = Warranty::create($data);
        return new GenericPayload($warranty, Response::HTTP_CREATED);

    }
}