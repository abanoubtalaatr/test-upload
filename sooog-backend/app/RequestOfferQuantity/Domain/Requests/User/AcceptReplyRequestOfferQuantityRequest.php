<?php

namespace App\RequestOfferQuantity\Domain\Requests\User;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;

class AcceptReplyRequestOfferQuantityRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'notes' => [
                'string',
                'required',
                'min:5'
            ],
            'reply_request_offer_quantity_id' => [
                'int',
                'required',
                'exists:reply_request_offer_quantities,id'
            ],
        ];
    }
}
