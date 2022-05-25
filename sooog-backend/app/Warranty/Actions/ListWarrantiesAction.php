<?php

namespace App\Warranty\Actions;
use App\Warranty\Domain\Requests\WarrantyRequest;
use App\Warranty\Domain\Services\ListWarrantiesService;
use App\Warranty\Responders\WarrantyResponder;

class ListWarrantiesAction 
{
    public function __construct(WarrantyResponder $responder, ListWarrantiesService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(WarrantyRequest $request) 
    {
        return $this->responder->withResponse(
            $this->services->handle($request)
        )->respond();
    }
}