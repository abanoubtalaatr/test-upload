<?php

namespace App\RequestOfferQuantity\Domain\Requests\User;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rule;

class ListRequestOfferQuantityRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'per_page' => ['sometimes', 'nullable', 'numeric', 'gte:1'],
            'is_paginated' => [
                'nullable', 'boolean'
            ],
            'filter' => [
                'nullable',
            ],
            'orderBy' => [
                'nullable',
                Rule::in(['category_id', 'product_name', 'status','created_at']),
            ],
            'orderType' => [
                'nullable',
                Rule::in(['ASC', 'DESC', 'asc', 'desc']),
            ],
        ];
    }
}
