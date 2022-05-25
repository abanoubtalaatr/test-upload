<?php

namespace App\RequestOfferQuantity\Domain\Resources;

use App\Infrastructure\Domain\Resources\GenericNameResource;
use App\RequestOfferQuantity\Domain\Models\ReplyRequestOfferQuantity;
use App\User\Domain\Resources\UserLiteResource;
use Illuminate\Http\Resources\Json\JsonResource;


class RequestOfferQuantityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'category' => new GenericNameResource($this->category),
            'product_name' => $this->product_name,
            'user' => new UserLiteResource($this->user),
            'image' => $this->image,
            'amount' => $this->amount,
            'status' => $this->status,
            'details' => $this->details,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->format('d/m/Y'),
            'auth_user_replied_before' => $this->checkAuthUserCreateReplyForRequestBefore(),
        ];
    }

    public function checkAuthUserCreateReplyForRequestBefore()
    {
        if(isset(auth()->guard('store')->user()->store->id)){
            $reply = ReplyRequestOfferQuantity::where('request_offer_quantity_id', $this->id)
            ->where('store_id', auth()->guard('store')->user()->store->id)
            ->first();

            if($reply){
                return true;
            }
            return false;
        }
        return false;
    }
}
