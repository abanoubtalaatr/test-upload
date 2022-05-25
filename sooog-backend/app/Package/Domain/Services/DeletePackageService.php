<?php

namespace App\Package\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use App\Package\Domain\Models\Package;
use Symfony\Component\HttpFoundation\Response;

class DeletePackageService extends Service
{
    public function handle($data = []) 
    {
        try {
            $package = Package::withCount('subscriptions')->findOrFail($data['package_id']);
            if($package->subscriptions_count >0)
                return new GenericPayload(
                    __('error.cannotDelete'), 422
                );
            $package->delete();
            return new GenericPayload(['message' => __('success.deletedSuccessfuly')], Response::HTTP_NO_CONTENT);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }

    }
}
