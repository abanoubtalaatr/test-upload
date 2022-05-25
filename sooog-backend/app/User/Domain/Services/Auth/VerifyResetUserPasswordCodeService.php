<?php

namespace App\User\Domain\Services\Auth;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\User\Domain\Models\PasswordReset;
use App\User\Domain\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Infrastructure\Exceptions\UserNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class VerifyResetUserPasswordCodeService extends Service
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
                $arr=['phone' => $data['phone'], 'token' => $data['token']];
            }else{
                $user = User::whereEmail($data['email'])->firstOrFail();
                $arr=['phone' => $data['email'], 'token' => $data['token']];
            }
            $check_token = PasswordReset::where($arr)->first();
            if(!$check_token)
                return new GenericPayload(
                    __('error.invalidCode'), 422
                );
            return new GenericPayload(['message' => __('success.validToken')], Response::HTTP_RESET_CONTENT);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new UserNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
    }
}
