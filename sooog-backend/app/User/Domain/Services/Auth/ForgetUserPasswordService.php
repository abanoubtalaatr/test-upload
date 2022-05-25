<?php

namespace App\User\Domain\Services\Auth;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\User\Domain\Models\PasswordReset;
use App\User\Domain\Models\User;
use Carbon\Carbon;
use App\Infrastructure\Exceptions\UserNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ForgetUserPasswordService extends Service
{
    public function __construct()
    {

    }

    public function handle($data = [])
    {
        try {
            if ($data['send_type'] == 'sms') {
                if (str_starts_with($data['phone'], '0')) {
                    $data['phone'] = substr($data['phone'], 1, 20);
                }
                $user = User::whereCountryCode($data['country_code'])->wherePhone($data['phone'])->firstOrFail();
            } else {
                $user = User::whereEmail($data['email'])->firstOrFail();
            }
            if ($user->phone_verified_at == null) {
                return new GenericPayload(__('error.accountNotActivated'), 425
                );
            }
            if ($user->is_active == 1) {
                $token = rand(1111, 9999);
                $user->update([
                    'verification_code' => $token
                ]);
                $message = "<#>Your code is {$token}";
                if ($data['send_type'] == 'sms') {
                    PasswordReset::updateOrCreate(
                        ['phone' => $user->phone, 'country_code' => $data['country_code']], ['token' => $token, 'created_at' => Carbon::now()]
                    );
                    sendSMS($user->country_code . $user->phone, $message);
                }else{
                    PasswordReset::updateOrCreate(
                        ['phone' => $user->email], ['token' => $token, 'created_at' => Carbon::now()]
                    );
                    \Mail::to($user->email)->send(new \App\Admin\Domain\Mail\ForgetPasswordMail($message));
                }



                //send sms to user phone with token

                return new GenericPayload(
                // __('success.TokenSentToPhone'), 200
                    [
                        'message' => __('success.TokenSentToPhone'),
                        'code' => $token
                    ],
                    Response::HTTP_RESET_CONTENT
                );
            }
            return new GenericPayload(
                __('error.inActiveUser'), 422
            );

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new UserNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
    }
}
