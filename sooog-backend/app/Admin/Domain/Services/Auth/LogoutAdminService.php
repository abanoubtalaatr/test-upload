<?php

namespace App\Admin\Domain\Services\Auth;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;

class LogoutAdminService extends Service
{
    public function handle($data = [])
    {
        optional(auth('admin')->user()->tokens->where('device_token', $data['device_token'])->first())->delete();
        auth("admin")->logout();
        return new GenericPayload(['message' => 'success']);
    }
}
