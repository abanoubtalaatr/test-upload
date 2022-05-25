<?php

namespace App\RequestOfferQuantity\Domain\Requests\Store;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;

class DeliveredRequestOfferQuantityRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'request_offer_quantity_id' => [
              'int',
              'required',
              'exists:request_offer_quantities,id'
            ]
        ];
    }
}
