<?php

namespace App\Offer\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Offer\Domain\Models\Offer;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ShowOfferService extends Service
{
    public function handle($data = []) 
    {
        try {
            $offer = Offer::findOrFail($data['offer_id']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
        return new GenericPayload($offer, Response::HTTP_CREATED);

    }
}