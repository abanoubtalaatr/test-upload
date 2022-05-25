<?php

namespace App\Refund\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rule;
class RefundReasonFormRequest extends CustomApiRequest
{
    public function rules()
    {
            $db = config('database.connections.mysql.database');
            switch ($this->method()) {
                case 'GET': {
                    return [
                        'per_page' => ['sometimes', 'nullable', 'numeric', 'gte:1'],
                        'orderBy' => [
                            'nullable',
                            Rule::in(['id', 'name', 'is_active', 'created_at']),
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
                    return [
                        'en.name' => [
                            'required',
                            'max:255',
                             Rule::unique('refund_reason_translations', 'name')
                                 ->where(function ($query) {
                                     $query->where('locale', 'en');
                                 })
                        ],
                        'ar.name' => [
                            'required',
                            'max:255',
                             Rule::unique('refund_reason_translations', 'name')
                                 ->where(function ($query) {
                                     $query->where('locale', 'ar');
                                 })
                        ],
                        'is_active' => ['sometimes', 'nullable', 'boolean'],
                        'type' => ['sometimes', 'in:other,normal']
                    ];
                }
                case 'PUT':
                case 'PATCH': {
                    return [
                        'en.name' => [
                            'sometimes',
                            'max:255',
                             Rule::unique('refund_reason_translations', 'name')
                                 ->where(function ($query) {
                                     $query->where('locale', 'en')->where('refund_reason_id','!=',$this->id);
                                 })
                        ],
                        'ar.name' => [
                            'sometimes',
                            'max:255',
                             Rule::unique('refund_reason_translations', 'name')
                                 ->where(function ($query) {
                                     $query->where('locale', 'ar')->where('refund_reason_id','!=',$this->id);
                                 })
                        ],
                        'is_active' => ['sometimes', 'nullable', 'boolean'],
                        'type' => ['sometimes', 'in:other,normal']
                    ];
                }
                default:break;
    
                }
    }
}
