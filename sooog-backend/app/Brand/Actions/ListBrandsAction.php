<?php

namespace App\Brand\Actions;
use App\Brand\Domain\Requests\BrandRequest;
use App\Brand\Domain\Services\ListBrandsService;
use App\Brand\Responders\BrandResponder;

class ListBrandsAction 
{
    public function __construct(BrandResponder $responder, ListBrandsService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(BrandRequest $request) 
    {
        return $this->responder->withResponse(
            $this->services->handle($request)
        )->respond();
    }
}