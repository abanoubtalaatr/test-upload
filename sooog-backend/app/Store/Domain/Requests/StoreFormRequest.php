<?php

namespace App\Store\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rule;

class StoreFormRequest extends CustomApiRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'GET': {
                return [
                    'per_page' => ['sometimes', 'nullable', 'numeric', 'gte:1'],
                    'is_paginated' => ['nullable', 'boolean'],
                    'latitude' => ['nullable', 'string'],
                    'longitude' => ['nullable', 'string'],

                    'orderBy' => [
                        'nullable',
                        Rule::in(['id', 'name', 'email', 'is_active', 'phone', 'created_at', 'is_featured']),
                    ],
                    'orderType' => [
                        'nullable',
                        Rule::in(['ASC', 'DESC', 'asc', 'desc']),
                    ],
                ];
            }
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                $rules =  [
                    'en.name' => [
                        'required',
                        'max:255',
                         // Rule::unique('store_translations', 'name')
                         //     ->where(function ($query) {
                         //         $query->where('locale', 'en');
                         //     })
                    ],
                    'ar.name' => [
                        'required',
                        'max:255',
                         // Rule::unique('store_translations', 'name')
                         //     ->where(function ($query) {
                         //         $query->where('locale', 'ar');
                         //     })
                    ],
                    // 'password' => ['nullable', 'string', 'min:6', 'max:20'],
                    // 'is_featured' => ['nullable', 'boolean'],
                    'phone' => ['required', 'digits_between:7,17',Rule::unique('stores','phone')->where('is_paid',1)],
                    'email' => ['required', 'email',Rule::unique('stores','email')->where('is_paid',1)],
                    'city_id' => ['required', 'numeric', 'exists:cities,id'],
                    'latitude' => ['required', 'string', 'max:255'],
                    'longitude' => ['required', 'string', 'max:255'],
                    'address' => ['nullable', 'string', 'max:255'],
                    'username' => ['required', 'string', 'max:255'],
                    'bank_name' => ['nullable', 'string', 'max:255'],
                    'iban_no' => ['nullable', 'string', 'max:255'],
                    'swift_code' => ['nullable', 'string', 'max:255'],
                    'bank_account_no' => ['nullable', 'string', 'max:255'],
                    'commercial_registry_no' => ['required', 'string', 'max:255'],
                    'commercial_registry_photo' => ['required', 'url', 'max:255'],
                    'type' => ['required', 'in:stores,centers'],
                    'image' => ['required', 'url'],
                    'package_id' => ['required', 'exists:packages,id'],
                    'payment_method_id' => ["nullable"],
                ];
                return $rules;
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    //'is_active' => ['required', 'numeric'],
                    // 'is_active' => [
                    //     Rule::requiredIf(function () {
                    //         return isset(request()->is_active);
                    //     }),
                    //     'numeric', 
                    //     'in:0,1'
                    // ],
                    'is_active' => ['nullable', 'boolean'],
                    'status' => [
                        Rule::requiredIf(function () {
                            return \Request::route()->getName() == "stores.update" && !isset(request()->has_delivery_service);
                        }),
                        'numeric',
                        'in:1,2'
                    ],
                    'rejection_reason' => [
                        // Rule::requiredIf(function () {
                        //     return isset(request()->status) && request()->status ==2;
                        // }),
                        'nullable',
                        'required_if:status,2',
                        'string', 
                        'max:255'
                    ],
                    'deactivation_reason' => [
                        // Rule::requiredIf(function () {
                        //     return isset(request()->is_active) && request()->is_active ==0;
                        // }),
                        'nullable',
                        //'required_with:is_active,1',
                        'string', 
                        'max:255'
                    ],
                    'has_delivery_service' => ['sometimes', 'boolean'],
                    'application_dues' => ['nullable', 'numeric', 'lte:100', 'gte:0'],
                    'delivery_charge' => ['nullable', 'regex:/^\d*(\.\d{3})?$/']
                    // 'en.name' => [
                    //     'sometimes',
                    //     'max:255',
                    //      Rule::unique('store_translations', 'name')
                    //          ->where(function ($query) use($this->id){
                    //              $query->where('locale', 'en')->where('store_id','!=',$this->id);
                    //          })
                    // ],
                    // 'ar.name' => [
                    //     'sometimes',
                    //     'max:255',
                    //      Rule::unique('store_translations', 'name')
                    //          ->where(function ($query) use($this->id) {
                    //              $query->where('locale', 'ar')->where('store_id','!=',$this->id);
                    //          })
                    // ],
                ];
            }
            default:break;
        }
    }
}
