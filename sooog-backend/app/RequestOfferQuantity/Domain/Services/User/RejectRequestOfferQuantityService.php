<?php

namespace App\RequestOfferQuantity\Domain\Services\User;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\RequestOfferQuantity\Domain\Models\ReplyRequestOfferQuantity;
use Symfony\Component\HttpFoundation\Response;

class RejectRequestOfferQuantityService extends Service
{
    public function handle($data = []): GenericPayload
    {
        $reply = ReplyRequestOfferQuantity::find($data['reply_request_offer_quantity_id']);

        $reply->update(['status' => 'Rejected']);

        return new GenericPayload($reply, Response::HTTP_PARTIAL_CONTENT);
    }
}

