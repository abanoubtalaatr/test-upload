<?php

namespace App\RequestOfferQuantity\Domain\Services\Store;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\RequestOfferQuantity\Domain\Models\RequestOfferQuantity;
use Symfony\Component\HttpFoundation\Response;

class DetailsRequestOfferQuantityService extends Service
{
    public function handle($data = []): GenericPayload
    {
        $requestOffer = RequestOfferQuantity::find($data['id']);

        return new GenericPayload($requestOffer, Response::HTTP_PARTIAL_CONTENT);

    }
}
