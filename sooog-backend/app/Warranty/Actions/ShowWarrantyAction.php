<?php

namespace App\Warranty\Actions;
use App\Warranty\Domain\Services\ShowWarrantyService;
use App\Warranty\Responders\WarrantyResponder;

class ShowWarrantyAction 
{
    public function __construct(WarrantyResponder $responder, ShowWarrantyService $services) 
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