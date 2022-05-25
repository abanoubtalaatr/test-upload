<?php

namespace App\Package\Actions;

use App\Package\Domain\Services\SubscribePackageService;
use App\Package\Responders\SubscribePackageResponder;

class StorePackageAction
{
    public function __construct(SubscribePackageResponder $responder, SubscribePackageService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke()
    {
        return $this->responder->withResponse(
            $this->services->handle()
        )->respond();
    }
}
