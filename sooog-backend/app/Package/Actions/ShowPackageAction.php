<?php

namespace App\Package\Actions;

use App\Package\Domain\Services\ShowPackageService;
use App\Package\Responders\PackageResponder;

class ShowPackageAction
{
    public function __construct(PackageResponder $responder, ShowPackageService $services)
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
