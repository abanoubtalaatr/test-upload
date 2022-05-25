<?php

namespace App\Store\Domain\Services\Auth;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;

class LogoutAdminService extends Service
{
    public function handle($data = [])
    {
        auth("store")->logout();
        return new GenericPayload(['message' => 'success']);
    }
}
