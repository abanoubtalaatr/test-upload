<?php

namespace App\Package\Actions;

use App\Package\Domain\Services\DeletePackageService;
use App\Package\Responders\PackageResponder;

class DeletePackageAction
{
    public function __construct(PackageResponder $responder, DeletePackageService $services)
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
