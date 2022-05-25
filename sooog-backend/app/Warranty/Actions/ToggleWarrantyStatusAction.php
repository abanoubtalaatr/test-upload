<?php

namespace App\Warranty\Actions;
use App\Warranty\Domain\Services\ToggleWarrantyStatusService;
use App\Warranty\Responders\WarrantyResponder;

class ToggleWarrantyStatusAction 
{
    public function __construct(WarrantyResponder $responder, ToggleWarrantyStatusService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(["warranty_id" => $id])
        )->respond();
    }
}