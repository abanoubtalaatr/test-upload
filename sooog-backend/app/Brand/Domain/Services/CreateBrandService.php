<?php

namespace App\Brand\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Brand\Domain\Models\Brand;
use Symfony\Component\HttpFoundation\Response;

class CreateBrandService extends Service
{
    public function handle($data = []) 
    {
        $data['is_active'] = isset($data['is_active']) ? $data['is_active'] : 1;
        $brand = Brand::create($data);
        return new GenericPayload($brand, Response::HTTP_CREATED);

    }
}