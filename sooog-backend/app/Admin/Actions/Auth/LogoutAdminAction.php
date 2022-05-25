<?php

namespace App\Admin\Actions\Auth;

use App\Admin\Domain\Services\Auth\LogoutAdminService;
use App\Admin\Responders\LogoutAdminResponder;
use App\User\Domain\Requests\LogoutUserFormRequest;

class LogoutAdminAction
{
    public function __construct(LogoutAdminResponder $responder, LogoutAdminService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }
    public function __invoke(LogoutUserFormRequest $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}
