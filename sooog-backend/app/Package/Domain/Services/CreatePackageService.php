<?php

namespace App\Package\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Package\Domain\Models\Package;
use Symfony\Component\HttpFoundation\Response;

class CreatePackageService extends Service
{
    public function handle($data = []) 
    {
        $data['is_active'] = isset($data['is_active']) ? $data['is_active'] : 1;
        $brand = Package::create($data);
        return new GenericPayload($brand, Response::HTTP_CREATED);

    }
}
