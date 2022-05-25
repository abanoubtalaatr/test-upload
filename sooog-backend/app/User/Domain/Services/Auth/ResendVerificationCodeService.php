<?php

namespace App\User\Domain\Services\Auth;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\User\Domain\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use App\Infrastructure\Exceptions\UserNotFoundException;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use App\User\Domain\Models\PasswordReset;

class ResendVerificationCodeService extends Service
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle($data = null)
    {
        try {
            if ($data['send_type'] == 'sms') {
                if (str_starts_with($data['phone'], '0')) {
                    $data['phone'] = substr($data['phone'], 1, 20);
                }
                $user = $this->user->whereCountryCode($data['country_code'])->wherePhone($data["phone"])->orWhere('updated_phone', $data['phone'])->firstOrFail();
                $arr = ['phone' => $data['phone'], 'country_code' => $data['country_code'], 'token' => $user->verification_code];
            } else {
                $user = $this->user->whereEmail($data['email'])->firstOrFail();
                $arr = ['phone' => $data['email'], 'token' => $user->verification_code];
            }
            $check_token = PasswordReset::where($arr)->first();

            $verification_code = rand(1111, 9999);

            if ($check_token)
                $check_token->update([
                    'token' => $verification_code
                ]);

            $user->update([
                'verification_code' => $verification_code
            ]);


            // if($user->phone_verified_at != NULL)
            //     return new GenericPayload(
            //          __('error.alreadyVerifiedAccount'), 422
            //     );
            $message = __('general.sms.phoneVerificationCode') . $verification_code;
            if ($data['send_type'] == 'sms') {
                sendSMS($user->country_code . $user->phone, $message);
            } else {
                \Mail::to($user->email)->send(new \App\Admin\Domain\Mail\ForgetPasswordMail($message));
            }
            //resend verification code 
            return new GenericPayload(
                [
                    'message' => __('success.successfullyResentCode'),
                    'code' => $verification_code
                ],
                Response::HTTP_RESET_CONTENT
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new UserNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
