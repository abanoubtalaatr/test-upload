<?php

namespace App\RequestOfferQuantity\Domain\Services\Store;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\RequestOfferQuantity\Domain\Models\ReplyRequestOfferQuantity;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class DeliveredRequestOfferQuantityService extends Service
{
    public function handle($data = []): GenericPayload
    {
        $reply = ReplyRequestOfferQuantity::where('request_offer_quantity_id', $data['request_offer_quantity_id'])
            ->where([
                'store_id' => auth()->guard('store')->user()->store->id,
                'status' => 'Accepted',
            ])->first();

        if($reply) {
            $reply->update(['status' => 'Delivered']);
            return new GenericPayload($reply, Response::HTTP_PARTIAL_CONTENT);
        }

        $msg = __('error.reply_request_offer_quantity.can_not_delivered');
        return new GenericPayload($msg, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
