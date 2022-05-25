<?php

namespace App\RequestOfferQuantity\Domain\Resources;

use App\Infrastructure\Domain\Resources\GenericNameResource;
use App\Package\Domain\Resources\StorePackageLiteResource;
use App\RequestOfferQuantity\Domain\Models\ReplyRequestOfferQuantity;
use App\User\Domain\Resources\UserLiteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReplyRequestOfferQuantityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'request_offer_quantity' => new RequestOfferQuantityResource($this->requestOfferQuantity),
            'user' => new GenericNameResource($this->requestOfferQuantity->user),
            'store' => new GenericNameResource($this->store),
            'category' => new GenericNameResource($this->requestOfferQuantity->category),
            'offer_price' => $this->offer_price,
            'notes' => $this->notes,
            'status' => $this->status,
            'invoice' => $this->invoice,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->format('d/m/Y'),
            'can_edit_reply' => $this->checkReplyIsPending(),
            'can_delivery' => $this->checkCanDeliveryRequestOffer(),
        ];
    }

    public function checkReplyIsPending(): bool
    {
        $reply = ReplyRequestOfferQuantity::where('id', $this->id)
            ->whereNotIn('status', ['Delivered', 'Accepted'])
            ->first();

        if($reply){
            return true;
        }
        return false;
    }

    public function checkCanDeliveryRequestOffer(): bool
    {
        $reply = ReplyRequestOfferQuantity::where('id', $this->id)
            ->whereIn('status',['accepted', 'Accepted'])->first();
        if($reply){
            return true;
        }
        return false;
    }
}
