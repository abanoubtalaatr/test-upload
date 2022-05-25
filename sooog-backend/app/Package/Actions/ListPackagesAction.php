<?php

namespace App\Package\Actions;

use App\Package\Domain\Requests\PackageRequest;
use App\Package\Domain\Services\ListPackagesService;
use App\Package\Responders\PackageResponder;

class ListPackagesAction
{
    public function __construct(PackageResponder $responder, ListPackagesService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(PackageRequest $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request)
        )->respond();
    }
}
