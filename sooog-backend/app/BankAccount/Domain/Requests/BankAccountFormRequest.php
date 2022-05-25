<?php

namespace App\BankAccount\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rule;
class BankAccountFormRequest extends CustomApiRequest
{
    public function rules()
    {
            switch ($this->method()) {
                case 'GET': {
                    return [
                        'orderBy' => [
                            'sometimes',
                            'nullable',
                            Rule::in(['id', 'name', 'created_at', 'is_active', 'account_number']),
                        ],
                        'orderType' => [
                            'sometimes',
                            'nullable',
                            Rule::in(['ASC', 'DESC', 'asc', 'desc']),
                        ],
                        'active' => ['sometimes', 'nullable'],
                        'is_paginated' => ['sometimes', 'nullable'],
                        'per_page'  => ['sometimes', 'nullable', 'numeric', 'gte:1']
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
                             // Rule::unique('bank_account_translations', 'name')
                             //     ->where(function ($query) {
                             //         $query->where('locale', 'en');
                             //     })
                        ],
                        'ar.name' => [
                            'required',
                            'max:255',
                             // Rule::unique('bank_account_translations', 'name')
                             //     ->where(function ($query) {
                             //         $query->where('locale', 'ar');
                             //     })
                        ],
                        'account_number' => ['required', 'numeric', 'min:1'],
                        'iban_number' => ['required', 'numeric', 'min:1'],
                        'is_active' => ['sometimes', 'nullable', 'boolean'],
                        'image' => ['required', 'url'],
                    ];
                }
                case 'PUT':
                case 'PATCH': {
                    return [
                        'en.name' => [
                            'sometimes',
                            'max:255',
                             // Rule::unique('bank_account_translations', 'name')
                             //     ->where(function ($query) {
                             //         $query->where('locale', 'en')->where('bank_account_id','!=',$this->id);
                             //     })
                        ],
                        'ar.name' => [
                            'sometimes',
                            'max:255',
                             // Rule::unique('bank_account_translations', 'name')
                             //     ->where(function ($query) {
                             //         $query->where('locale', 'ar')->where('bank_account_id','!=',$this->id);
                             //     })
                        ],
                        'is_active' => ['sometimes', 'nullable', 'boolean'],
                        'account_number' => ['sometimes', 'numeric', 'min:1'],
                        'iban_number' => ['sometimes', 'numeric', 'min:1'],
                        'image' => ['sometimes', 'url'],
                    ];
                }
                default:break;
    
                }
    }
}
