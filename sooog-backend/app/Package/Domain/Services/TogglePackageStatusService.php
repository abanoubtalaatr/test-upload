<?php

namespace App\Package\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use App\Package\Domain\Models\Package;
use Symfony\Component\HttpFoundation\Response;

class TogglePackageStatusService extends Service
{
    public function handle($data = []) 
    {
        try {
            $package = Package::findOrFail($data['package_id']);
            $package->update([
                'is_active' => !$package->is_active
            ]);
            return new GenericPayload($package, Response::HTTP_CREATED);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
    }
}
