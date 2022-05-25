<?php

namespace App\Store\Actions\Auth;

use App\Admin\Domain\Requests\ForgetPasswordRequest;
use App\Store\Domain\Services\Auth\ForgetPasswordService;
use App\Admin\Responders\ChangePasswordResponder;

class ForgetPasswordAction
{
    public function __construct(ChangePasswordResponder $responder, ForgetPasswordService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }
    public function __invoke(ForgetPasswordRequest $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}
