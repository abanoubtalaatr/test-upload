<?php

namespace App\Brand\Actions;
use App\Brand\Domain\Requests\BrandRequest;
use App\Brand\Domain\Services\UpdateBrandService;
use App\Brand\Responders\BrandResponder;

class UpdateBrandAction 
{
    public function __construct(BrandResponder $responder, UpdateBrandService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(BrandRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(array_merge($request->validated(), ["brand_id" => $id]))
        )->respond();
    }
}