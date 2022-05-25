<?php

namespace App\RequestOfferQuantity\Domain\Requests\Store;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;

class UpdateReplyRequestOfferQuantityRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'reply_request_offer_quantity_id' => [
                'int',
                'required',
                'exists:reply_request_offer_quantities,id'
            ],
            'offer_price' => [
                'required',
                'string',
            ],
            'invoice' => [
                'nullable',
                'mines:jpg,png,jpeg,pdf',
            ]
        ];
    }
}
