<?php

namespace App\Product\Actions;
use App\Product\Domain\Requests\ProductRequest;
use App\Product\Domain\Services\UpdateProductService;
use App\Product\Responders\ProductResponder;

class UpdateProductAction 
{
    public function __construct(ProductResponder $responder, UpdateProductService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(ProductRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(array_merge($request->validated(), ["product_id" => $id]))
        )->respond();
    }
}