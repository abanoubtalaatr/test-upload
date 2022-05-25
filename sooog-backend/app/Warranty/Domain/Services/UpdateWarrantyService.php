<?php

namespace App\Warranty\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Warranty\Domain\Models\Warranty;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class UpdateWarrantyService extends Service
{
    public function handle($data = []) 
    {
        try {
            $warranty = Warranty::findOrFail($data['warranty_id']);
            $warranty->update($data);
            return new GenericPayload($warranty, Response::HTTP_CREATED);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
        

    }
}