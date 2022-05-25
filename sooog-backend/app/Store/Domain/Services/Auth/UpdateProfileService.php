<?php

namespace App\Store\Domain\Services\Auth;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Admin\Domain\Models\Admin;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\Store\Domain\Models\StoreTemp;
use Illuminate\Support\Arr;

class UpdateProfileService extends Service
{
    public function handle($data = [])
    {
        try {
            $admin = auth()->user();
            $admin->update($data);
            if($admin->store && isset($data['avatar'])) {
                // $data['image'] = $data['avatar'];
                //dd($data['image']);
//                $admin->store->update(Arr::only($data, ["email", "phone", "image", "ar", "en"]));
            }

        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
        return new GenericPayload($admin);
    }
}
