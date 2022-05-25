<?php

namespace App\RequestOfferQuantity\Domain\Requests\Store;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;

class CreateReplyRequestOfferQuantityRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'offer_price' => [
                'required',
                'string',
                'max:500'
            ],
            'request_offer_quantity_id' => [
                'int',
                'required',
                'exists:request_offer_quantities,id',
            ],
            'invoice' => [
                'required',
                'max:10000',
                'mimes:png,pdf,jpg,jpeg'
            ],
        ];
    }
}
