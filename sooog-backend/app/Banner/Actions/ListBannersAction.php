<?php

namespace App\Banner\Actions;

use App\Banner\Domain\Requests\BannerRequest;
use App\Banner\Domain\Services\ListBannersService;
use App\Banner\Responders\BannerResponder;

class ListBannersAction
{
    public function __construct(BannerResponder $responder, ListBannersService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(BannerRequest $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request)
        )->respond();
    }
}
