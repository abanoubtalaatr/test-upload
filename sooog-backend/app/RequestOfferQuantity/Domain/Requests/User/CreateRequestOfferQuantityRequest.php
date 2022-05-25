<?php

namespace App\RequestOfferQuantity\Domain\Requests\User;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;

class CreateRequestOfferQuantityRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'product_name' => [
              'required',
              'string',
            ],
            'category_id' => [
                'int',
                'required',
                'exists:categories,id',
            ],
            'image' => [
                'required',
                'mimes:jpeg,jpg,png',
                'max:10000'
            ],
            'amount' => [
                'required',
                'int',
            ],
            'details' => [
                'required',
                'string',
                'min:5',
                'max:500'
            ],
        ];
    }
}
