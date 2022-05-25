<?php

namespace App\Package\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use App\Package\Domain\Models\Package;
use Symfony\Component\HttpFoundation\Response;

class ShowPackageService extends Service
{
    public function handle($data = []) 
    {
        try {
            $brand = Package::findOrFail($data['package_id']);
            return new GenericPayload($brand, Response::HTTP_CREATED);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
    }
}
