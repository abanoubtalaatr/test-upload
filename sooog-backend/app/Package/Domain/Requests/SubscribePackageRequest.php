<?php

namespace App\Package\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use App\Package\Domain\Models\Package;
use Illuminate\Validation\Rule;

class SubscribePackageRequest extends CustomApiRequest
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
                        'is_paginated' => ['nullable'],
                        'active' => ['nullable'],
                        'is_detailed' => ['nullable'],
                        'per_page'  => ['nullable', 'numeric', 'gte:1'],
                    ];
                }
                case 'DELETE': {
                    return [];
                }
                case 'POST': {
                    return [
                        'package_id' => ['required', 'exists:packages,id'],
                        'store_id' => ['required', 'exists:stores,id'],
                        'payment_method_id' => ["nullable"],
                    ];
                }
                case 'PUT':
                case 'PATCH': {
                    return [
//                        'en.name' => [
//                            'nullable',
//                            'max:255',
//                            Rule::unique('package_translations', 'name')
//                                ->where(function ($query) {
//                                    $query->where('locale', 'en')->where('package_id','!=',$this->id);
//                                })
//                        ],
//                        'ar.name' => [
//                            'nullable',
//                            'max:255',
//                            Rule::unique('package_translations', 'name')
//                                ->where(function ($query) {
//                                    $query->where('locale', 'ar')->where('package_id','!=',$this->id);
//                                })
//                        ],
//                        'image' => ['nullable', 'url'],
//                        'price' => ['nullable', 'regex:/^\d*(\.\d{3})?$/'],
//                        'months' => ['nullable', 'min:1'],
//                        'product_number' => ['nullable','numeric'],
//                        'order_number' => ['nullable','numeric'],
//                        'has_chat' => ['nullable', 'boolean'],
//                        'is_free' => ['nullable', 'boolean'],
//                        'is_rfq' => ['nullable', 'boolean'],
//                        'is_active' => ['nullable', 'boolean'],
                    ];
                }
                default:break;
    
                }
    }
}
