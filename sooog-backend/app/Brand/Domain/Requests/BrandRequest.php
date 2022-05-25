<?php

namespace App\Brand\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rule;
class BrandRequest extends CustomApiRequest
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
                        'en.name' => [
                            'required',
                            'max:255',
                             // Rule::unique('brand_translations', 'name')
                             //     ->where(function ($query) {
                             //         $query->where('locale', 'en');
                             //     })
                        ],
                        'ar.name' => [
                            'required',
                            'max:255',
                             // Rule::unique('brand_translations', 'name')
                             //     ->where(function ($query) {
                             //         $query->where('locale', 'ar');
                             //     })
                        ],
                        'en.description' => ['nullable', 'max:1000'],
                        'ar.description' => ['nullable', 'max:1000'],
                        'image' => ['required', 'url'],
                        'is_active' => ['nullable', 'boolean'],
                    ];
                }
                case 'PUT':
                case 'PATCH': {
                    return [
                        'en.name' => [
                            'nullable',
                            'max:255',
                             // Rule::unique('brand_translations', 'name')
                             //     ->where(function ($query) {
                             //         $query->where('locale', 'en')->where('brand_id','!=',$this->id);
                             //     })
                        ],
                        'ar.name' => [
                            'nullable',
                            'max:255',
                             // Rule::unique('brand_translations', 'name')
                             //     ->where(function ($query) {
                             //         $query->where('locale', 'ar')->where('brand_id','!=',$this->id);
                             //     })
                        ],
                        'en.description' => ['nullable', 'max:1000'],
                        'ar.description' => ['nullable', 'max:1000'],
                        'image' => ['nullable', 'url'],
                        'is_active' => ['nullable', 'boolean'],
                    ];
                }
                default:break;
    
                }
    }
}
