<?php

namespace App\Package\Actions;

use App\Package\Domain\Requests\PackageRequest;
use App\Package\Domain\Services\UpdatePackageService;
use App\Package\Responders\PackageResponder;

class UpdatePackageAction
{
    public function __construct(PackageResponder $responder, UpdatePackageService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(PackageRequest $request, $id)
    {
        return $this->responder->withResponse(
            $this->services->handle(array_merge($request->validated(), ["package_id" => $id]))
        )->respond();
    }
}
