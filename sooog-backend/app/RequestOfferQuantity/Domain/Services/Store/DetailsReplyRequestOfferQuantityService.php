<?php

namespace App\RequestOfferQuantity\Domain\Services\Store;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\RequestOfferQuantity\Domain\Models\ReplyRequestOfferQuantity;
use Symfony\Component\HttpFoundation\Response;

class DetailsReplyRequestOfferQuantityService extends Service
{
    public function handle($data = []): GenericPayload
    {
        $requestOffer = ReplyRequestOfferQuantity::findOrFail($data['id']);

        return new GenericPayload($requestOffer, Response::HTTP_PARTIAL_CONTENT);
    }
}
