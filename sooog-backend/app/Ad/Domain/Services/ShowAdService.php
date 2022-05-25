<?php

namespace App\Ad\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Ad\Domain\Models\Ad;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ShowAdService extends Service
{
    public function handle($data = []) 
    {
        try {
            $ad = Ad::findOrFail($data['ad_id']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
        return new GenericPayload($ad, Response::HTTP_CREATED);

    }
}