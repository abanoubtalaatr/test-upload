<?php

namespace App\Package\Actions;

use App\Package\Domain\Services\TogglePackageStatusService;
use App\Package\Responders\PackageResponder;

class TogglePackageStatusAction
{
    public function __construct(PackageResponder $responder, TogglePackageStatusService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(["package_id" => $id])
        )->respond();
    }
}
