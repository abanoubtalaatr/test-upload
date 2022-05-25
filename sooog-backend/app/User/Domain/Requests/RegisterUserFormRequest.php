<?php

namespace App\User\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;

class RegisterUserFormRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'min:4', 'max:40', 'string'],
            'send_type' => ['required', 'in:sms,email'],
            //'phone' => ['required', 'digits_between:7,17', 'unique:users,phone'],
            'phone' => ['required', 'digits_between:7,17'],
            'email' => ['nullable', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:32', 'confirmed'],
            'gender' => ['sometimes', 'required', 'in:male,female'],
            'country_code' => ['required', 'exists:countries,code'],
            'latitude' => ['required', 'string', 'max:255'],
            'longitude' => ['required', 'string', 'max:255'],
//            'confirmation' => ['required', 'in:1'],
        ];
    }
}
