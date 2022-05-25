<?php

namespace App\Warranty\Actions;
use App\Warranty\Domain\Services\DeleteWarrantyService;
use App\Warranty\Responders\WarrantyResponder;

class DeleteWarrantyAction 
{
    public function __construct(WarrantyResponder $responder, DeleteWarrantyService $services) 
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