<?php

namespace App\Package\Actions;

use App\Package\Domain\Requests\PackageRequest;
use App\Package\Domain\Services\CreatePackageService;
use App\Package\Responders\PackageResponder;

class CreatePackageAction
{
    public function __construct(PackageResponder $responder, CreatePackageService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(PackageRequest $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}
