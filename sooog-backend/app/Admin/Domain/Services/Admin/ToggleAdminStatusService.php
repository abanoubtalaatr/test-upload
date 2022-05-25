<?php

namespace App\Admin\Domain\Services\Admin;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Admin\Domain\Models\Admin;
use App\Infrastructure\Exceptions\UserNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ToggleAdminStatusService extends Service
{
    public function handle($data = []) 
    {
        try {
            $admin = Admin::findOrFail($data['admin_id']);
            if(!($admin->hasRole('super admin') || $admin->hasRole('super-admin'))){
                $admin->update([
                    'is_active' => !$admin->is_active
                ]);
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new UserNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
        return new GenericPayload($admin, Response::HTTP_CREATED);

    }
}