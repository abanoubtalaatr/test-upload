<?php

namespace App\Banner\Actions;

use App\Banner\Domain\Requests\BannerRequest;
use App\Banner\Domain\Services\UpdateBannerService;
use App\Banner\Responders\BannerResponder;

class UpdateBannerAction
{
    public function __construct(BannerResponder $responder, UpdateBannerService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(BannerRequest $request, $id)
    {
        return $this->responder->withResponse(
            $this->services->handle(array_merge($request->validated(), ["banner_id" => $id]))
        )->respond();
    }
}
