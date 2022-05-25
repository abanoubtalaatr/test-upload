<?php

namespace App\Warranty\Actions;
use App\Warranty\Domain\Requests\WarrantyRequest;
use App\Warranty\Domain\Services\CreateWarrantyService;
use App\Warranty\Responders\WarrantyResponder;

class CreateWarrantyAction 
{
    public function __construct(WarrantyResponder $responder, CreateWarrantyService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(WarrantyRequest $request) 
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}