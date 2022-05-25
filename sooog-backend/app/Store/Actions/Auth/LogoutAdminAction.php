<?php

namespace App\Store\Actions\Auth;

use App\Store\Domain\Services\Auth\LogoutAdminService;
use App\Admin\Responders\LogoutAdminResponder;

class LogoutAdminAction
{
    public function __construct(LogoutAdminResponder $responder, LogoutAdminService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }
    public function __invoke()
    {
        return $this->responder->withResponse(
            $this->services->handle()
        )->respond();
    }
}
