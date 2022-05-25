<?php

namespace App\Warranty\Actions;
use App\Warranty\Domain\Requests\WarrantyRequest;
use App\Warranty\Domain\Services\UpdateWarrantyService;
use App\Warranty\Responders\WarrantyResponder;

class UpdateWarrantyAction 
{
    public function __construct(WarrantyResponder $responder, UpdateWarrantyService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(WarrantyRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(array_merge($request->validated(), ["warranty_id" => $id]))
        )->respond();
    }
}