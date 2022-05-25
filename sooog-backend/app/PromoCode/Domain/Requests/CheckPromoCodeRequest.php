<?php

namespace App\PromoCode\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rule;
class CheckPromoCodeRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'promo_code' => ['required', 'string', 'min:1', 'max:255', 'exists:promo_codes,code'],
            'store_id' => ['required', 'numeric', 'exists:stores,id'],
            //'user_id' => ['nullable', 'numeric', 'exists:users,id'],

        ];
    }
}
