<?php

namespace App\RequestOfferQuantity\Domain\Services\Store;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Helpers\Traits\UploaderHelper;
use App\RequestOfferQuantity\Domain\Models\ReplyRequestOfferQuantity;
use App\RequestOfferQuantity\Domain\Models\RequestOfferQuantity;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CreateReplayRequestOfferQuantityService extends Service
{
    use UploaderHelper;

    public function handle($data = []): GenericPayload
    {
        $data = Arr::add($data, 'status', 'Pending');
        $data = Arr::add($data, 'invoice', $this->handleUploadImg($data['invoice'], 'request/offer/invoice'),);
        $data = Arr::add($data, 'store_id', auth()->guard('store')->user()->store->id);

        $existBefore = ReplyRequestOfferQuantity::where( 'store_id', auth()->guard('store')->user()->store->id)
        ->where( 'request_offer_quantity_id' , $data['request_offer_quantity_id'])
        ->first();

        if ($existBefore) {
            $msg = __('error.reply_request_offer_quantity.can_not_create');
            return new GenericPayload($msg, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        DB::beginTransaction();

        $reply = ReplyRequestOfferQuantity::create($data);

        RequestOfferQuantity::findOrFail($data['request_offer_quantity_id'])->update([
            'status' => 'Replied'
        ]);
        DB::commit();

        return new GenericPayload($reply, Response::HTTP_CREATED);
    }
}
