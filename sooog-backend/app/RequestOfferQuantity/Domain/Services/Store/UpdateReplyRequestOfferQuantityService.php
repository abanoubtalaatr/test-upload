<?php

namespace App\RequestOfferQuantity\Domain\Services\Store;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Helpers\Traits\UploaderHelper;
use App\RequestOfferQuantity\Domain\Models\ReplyRequestOfferQuantity;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class UpdateReplyRequestOfferQuantityService extends Service
{
    use UploaderHelper;

    public function handle($data = []): GenericPayload
    {

        $reply = ReplyRequestOfferQuantity::where([
            'id' => $data['reply_request_offer_quantity_id'],
            'store_id' => auth()->guard('store')->user()->store->id,
        ])->whereNotIn('status', ['accepted ', 'delivered'])->first();

        if(isset($data['invoice'])) {
            $this->deleteFile($reply->invoice, 'request/offer/invoice');
            $data['invoice'] = $this->handleUploadImg($data['invoice'],'request/offer/invoice');
        }

        if ($reply) {
            $reply->update([
                'offer_price' => $data['offer_price'],
                'invoice' => $data['invoice'] ?? $reply->invoice,
            ]);

            return new GenericPayload($reply, Response::HTTP_PARTIAL_CONTENT);
        }

        return new GenericPayload([__('error.reply_request_offer_quantity.can_not_updated')],
            Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
