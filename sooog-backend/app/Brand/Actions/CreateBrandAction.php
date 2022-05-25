<?php

namespace App\Brand\Actions;
use App\Brand\Domain\Requests\BrandRequest;
use App\Brand\Domain\Services\CreateBrandService;
use App\Brand\Responders\BrandResponder;

class CreateBrandAction 
{
    public function __construct(BrandResponder $responder, CreateBrandService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(BrandRequest $request) 
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}