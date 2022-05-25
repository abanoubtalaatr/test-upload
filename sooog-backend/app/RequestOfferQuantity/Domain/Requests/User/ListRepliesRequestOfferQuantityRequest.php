<?php

namespace App\RequestOfferQuantity\Domain\Requests\User;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rule;

class ListRepliesRequestOfferQuantityRequest extends CustomApiRequest
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
                Rule::in(['Waiting', 'waiting','Replied', 'replied','Accept', 'accept', 'Delivered', 'delivered', 'Reject', 'reject']),
            ],
            'orderBy' => [
                'nullable',
                Rule::in(['store_id', 'category_id', 'product_id', 'status','created_at']),
            ],
            'orderType' => [
                'nullable',
                Rule::in(['ASC', 'DESC', 'asc', 'desc']),
            ],
        ];
    }
}
