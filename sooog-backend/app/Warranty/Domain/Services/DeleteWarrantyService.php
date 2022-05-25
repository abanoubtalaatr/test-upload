<?php

namespace App\Warranty\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Warranty\Domain\Models\Warranty;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class DeleteWarrantyService extends Service
{
    public function handle($data = []) 
    {
        try {
            $warranty = Warranty::findOrFail($data['warranty_id']);
            if(count($warranty->orders()->get()) > 0)
                return new GenericPayload(
                     __('error.cannotDelete'), 422
                ); 
            $warranty->delete();
            return new GenericPayload(['message' => __('success.deletedSuccessfuly')], Response::HTTP_NO_CONTENT);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }

    }
}