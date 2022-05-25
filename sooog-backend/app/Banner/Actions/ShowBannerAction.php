<?php

namespace App\Banner\Actions;

use App\Banner\Domain\Services\ShowBannerService;
use App\Banner\Responders\BannerResponder;

class ShowBannerAction
{
    public function __construct(BannerResponder $responder, ShowBannerService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(["banner_id" => $id])
        )->respond();
    }
}
