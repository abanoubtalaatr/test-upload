<?php

namespace App\RequestOfferQuantity\Domain\Requests\User;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;

class DetailsRequestOfferQuantityRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'request_offer_quantity_id' => [
              'int',
              'required',
              'exists:request_offer_quantities,id'
            ],
        ];
    }
}
