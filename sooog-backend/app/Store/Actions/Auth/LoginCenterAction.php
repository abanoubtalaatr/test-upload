<?php

namespace App\Store\Actions\Auth;

use App\Admin\Domain\Requests\LoginAdminFormRequest;
use App\Store\Domain\Services\Auth\LoginCenterService;
use App\Admin\Responders\LoginAdminResponder;

class LoginCenterAction
{
    public function __construct(LoginAdminResponder $responder, LoginCenterService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(LoginAdminFormRequest $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}
