<?php

namespace App\User\Domain\Services\Auth;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\User\Domain\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserService extends Service
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle($data = [])
    {
        $data['password'] = Hash::make($data['password']);
        $data['verification_code'] = rand(1111, 9999);
        if (str_starts_with($data['phone'], '0')) {
            $data['phone'] = substr($data['phone'], 1, 20);
        }

        $check_user_phone = User::wherePhone($data['phone'])->whereCountryCode($data['country_code'])->first();

        if ($check_user_phone)
            return new GenericPayload(__('error.duplicatePhone'), 422);

        $user = $this->user->create($data);
        $message = __('general.sms.phoneVerificationCode') . $data['verification_code'];
        if ($data['send_type'] == 'sms') {
            sendSMS($data['country_code'] . $data['phone'], $message);
        } else {
            \Mail::to($user->email)->send(new \App\Admin\Domain\Mail\ForgetPasswordMail($message));
        }
        //$user = $this->user->create(Arr::only($data, ["name", "email", "password", "is_active"]));
        return new GenericPayload(
            [
                'message' => __('success.successfullyRegistered'),
                //'code'    => $user->verification_code
            ],
            Response::HTTP_RESET_CONTENT
        );
    }
}
