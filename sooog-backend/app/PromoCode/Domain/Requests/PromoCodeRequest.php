<?php

namespace App\PromoCode\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rule;
class PromoCodeRequest extends CustomApiRequest
{
    public function rules()
    {
            switch ($this->method()) {
                case 'GET': {
                    return [
                        'orderBy' => [
                            'nullable',
                            Rule::in(['id', 'name', 'type', 'code', 'created_at', 'is_active']),
                        ],
                        'orderType' => [
                            'nullable',
                            Rule::in(['ASC', 'DESC', 'asc', 'desc']),
                        ],
                        'active' => ['nullable'],
                        'per_page'  => ['nullable', 'numeric', 'gte:1']
                    ];
                }
                case 'DELETE': {
                    return [];
                }
                case 'POST': {
                    $rules = [
                        'code' => ['required', 'string', 'min:1', 'max:255', 'unique:promo_codes,code'],
                        'en.name' => [
                            'required',
                            'max:255',
                             // Rule::unique('promo_code_translations', 'name')
                             //     ->where(function ($query) {
                             //         $query->where('locale', 'en');
                             //     })
                        ],
                        'ar.name' => [
                            'required',
                            'max:255',
                             // Rule::unique('promo_code_translations', 'name')
                             //     ->where(function ($query) {
                             //         $query->where('locale', 'ar');
                             //     })
                        ],
                        'type' => ['required', 'in:percentage,value,free_delivery_charge,free_cash_charge'],
                        'applied_to' => ['required', 'in:all_users,specific_user'],
                        'is_active' => ['nullable', 'boolean'],
                        'start_date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:today'],
                        'end_date' => ['required', 'date', 'date_format:Y-m-d', 'after:start_date'],
                        'max_use_number' => ['required', 'numeric','digits_between:1,4000'],
                        'order_min_cost' => ['required', 'regex:/^\d*(\.\d{3})?$/'],
                        'stores' => ['nullable', 'array'],
                        'stores.*' => ['nullable', 'exists:stores,id']
                    ];
                    if (request()->type == "percentage") {
                        $rules['value'] = ['required', 'numeric', 'lte:100', 'gt:0'];
                    }

                    if (request()->type == "value") {
                        $rules['value'] = ['required', 'regex:/^\d*(\.\d{3})?$/'];
                    }
                    if (request()->applied_to == "specific_user") {
                        $rules['user_id']  = ['required', 'exists:users,id'];
                    }
                    return $rules;
                }
                case 'PUT':
                case 'PATCH': {
                    $rules = [
                        'code' => ['nullable', 'string', 'min:1', 'max:255', 'unique:promo_codes,code,'.$this->id],
                        'en.name' => [
                            'nullable',
                            'max:255',
                             // Rule::unique('promo_code_translations', 'name')
                             //     ->where(function ($query) {
                             //         $query->where('locale', 'en')->where('promo_code_id','!=',$this->id);
                             //     })
                        ],
                        'ar.name' => [
                            'nullable',
                            'max:255',
                             // Rule::unique('promo_code_translations', 'name')
                             //     ->where(function ($query) {
                             //         $query->where('locale', 'ar')->where('promo_code_id','!=',$this->id);
                             //     })
                        ],
                        'type' => ['nullable', 'in:percentage,value,free_delivery_charge,free_cash_charge'],
                        'applied_to' => ['nullable', 'in:all_users,specific_user'],
                        'is_active' => ['nullable', 'boolean'],
                        'start_date' => ['nullable', 'date', 'date_format:Y-m-d'],
                        'end_date' => ['nullable', 'date', 'date_format:Y-m-d', 'after:start_date'],
                        'max_use_number' => ['nullable', 'numeric','digits_between:1,4000'],
                        'order_min_cost' => ['nullable', 'regex:/^\d*(\.\d{3})?$/'],
                        'stores' => ['nullable', 'array'],
                        'stores.*' => ['nullable', 'exists:stores,id']
                    ];
                    if (isset(request()->type) && request()->type == "percentage") {
                        $rules['value'] = ['required', 'numeric', 'lte:100', 'gt:0'];
                    }

                    if (isset(request()->type) && request()->type == "value") {
                        $rules['value'] = ['required', 'regex:/^\d*(\.\d{3})?$/'];
                    }
                    if (isset(request()->applied_to) && request()->applied_to == "specific_user") {
                        $rules['user_id'] = ['required', 'exists:users,id'];
                    }
                    return $rules;
                }
                default:break;

                }
    }

    public function messages()
    {
        return [
            'start_date.after_or_equal'=>trans('validation.after_or_equal',['attribute'=>trans('validation.attributes.start_date'),'date'=>trans('validation.attributes.today')]),

        ];
    }
}
