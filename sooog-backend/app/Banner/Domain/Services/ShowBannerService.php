<?php

namespace App\Banner\Domain\Services;

use App\Banner\Domain\Models\Banner;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ShowBannerService extends Service
{
    public function handle($data = []) 
    {
        try {
            $ad = Banner::findOrFail($data['banner_id']);
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
