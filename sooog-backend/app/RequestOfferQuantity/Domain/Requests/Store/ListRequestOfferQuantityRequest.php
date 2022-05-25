<?php

namespace App\RequestOfferQuantity\Domain\Requests\Store;

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
                Rule::in(['Pending', 'pending','Finished','finished','Replied', 'replied','Accepted', 'accepted', 'Delivered', 'delivered', 'Reject', 'reject']),
            ],
            'orderBy' => [
                'nullable',
                Rule::in(['user_id', 'category_id', 'product_id', 'status','created_at']),
            ],
            'orderType' => [
                'nullable',
                Rule::in(['ASC', 'DESC', 'asc', 'desc']),
            ],
        ];
    }
}
