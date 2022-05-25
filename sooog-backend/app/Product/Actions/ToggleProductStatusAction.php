<?php

namespace App\Product\Actions;
use App\Product\Domain\Services\ToggleProductStatusService;
use App\Product\Responders\ProductResponder;
use App\Product\Domain\Requests\UpdateProductStatusFormRequest;

class ToggleProductStatusAction 
{
    public function __construct(ProductResponder $responder, ToggleProductStatusService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(UpdateProductStatusFormRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(array_merge($request->validated(), ["product_id" => $id]))
        )->respond();
    }
}