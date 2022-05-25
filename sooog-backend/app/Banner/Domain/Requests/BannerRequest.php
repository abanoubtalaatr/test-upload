<?php

namespace App\Banner\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rule;
class BannerRequest extends CustomApiRequest
{
    public function rules()
    {
            switch ($this->method()) {
                case 'GET': {
                    return [
                        'orderBy' => [
                            'sometimes',
                            'nullable',
                            Rule::in(['id', 'name', 'created_at', 'is_active']),
                        ],
                        'orderType' => [
                            'sometimes',
                            'nullable',
                            Rule::in(['ASC', 'DESC', 'asc', 'desc']),
                        ],
                        'is_paginated' => ['sometimes', 'nullable'],
                        'active' => ['sometimes', 'nullable'],
                        'is_detailed' => ['sometimes', 'nullable'],
                        'per_page'  => ['sometimes', 'nullable', 'numeric', 'gte:1']
                    ];
                }
                case 'DELETE': {
                    return [];
                }
                case 'POST': {
                    return [
                        'image' => ['required', 'url'],
                        'is_active' => ['nullable', 'boolean'],

                    ];
                }
                case 'PUT':
                case 'PATCH': {
                    return [
                        'image' => ['nullable', 'url'],
                        'is_active' => ['nullable', 'boolean'],
                    ];
                }
                default:break;
    
                }
    }
}
