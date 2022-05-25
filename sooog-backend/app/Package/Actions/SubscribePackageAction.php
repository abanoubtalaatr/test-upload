<?php

namespace App\Package\Actions;

use App\Package\Domain\Requests\SubscribePackageRequest;
use App\Package\Domain\Services\SubscribePackageService;
use App\Package\Responders\SubscribePackageResponder;

class SubscribePackageAction
{
    public function __construct(SubscribePackageResponder $responder, SubscribePackageService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(SubscribePackageRequest $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}
