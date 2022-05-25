<?php

namespace App\Admin\Actions\Auth;

use App\Admin\Domain\Requests\ChangePasswordFormRequest;
use App\Admin\Domain\Services\Auth\ChangePasswordService;
use App\Admin\Responders\ChangePasswordResponder;

class ChangePasswordAction
{
    public function __construct(ChangePasswordResponder $responder, ChangePasswordService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }
    public function __invoke(ChangePasswordFormRequest $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}
