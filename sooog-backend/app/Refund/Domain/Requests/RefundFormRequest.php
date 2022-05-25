<?php

namespace App\Refund\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rule;
class RefundFormRequest extends CustomApiRequest
{
    public function rules()
    {
            //`order_id`, `status_id`, `refund_reason_id`, `refund_type`, `note`,
            switch ($this->method()) {
                case 'GET': {
                    return [
                        'per_page' => ['sometimes', 'nullable', 'numeric', 'gte:1'],
                        'orderBy' => [
                            'nullable',
                            Rule::in(['id', 'total', 'created_at']),
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
                    $rules = [
                        'refund_reason_id' => ['required', 'numeric', 'exists:refund_reasons,id'],
                        'order_id' => ['sometimes', 'numeric', 'exists:orders,id'],
                        'refund_type' => ['required', 'in:order,items'],
                        //'payment_method_id' => ['sometimes', 'numeric', 'exists:payment_methods,id'],
                        'note' => ['sometimes', 'nullable', 'string', 'max:1000'],
                    ];
                    if(request()->refund_type == 'items' ){
                        $rules = array_merge($rules, [
                            'items' => ['required', 'array'],
                            'items.*.order_item_id' => ['sometimes', 'numeric', 'exists:order_items,id'],
                            'items.*.quantity' => ['sometimes', 'numeric'],
                            'items.*.note' => ['nullable', 'string', 'max:1000', 'min:1'],
                        ]);
                    }
                        
                    return $rules;
                }
                case 'PUT':
                case 'PATCH': {
                    return [
                        'status' => ['required', 'in:rejected,accepted,replaced'],
                        'reason' => [
                            Rule::requiredIf(function () {
                                return isset(request()->status) && request()->status =='rejected';
                            }),
                            'nullable',
                            // 'string', 
                           // 'min:2',
                            'max:255'
                        ],
                    ];
                }
                default:break;
    
                }
    }
}
