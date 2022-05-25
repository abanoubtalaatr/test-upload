<?php

namespace App\Product\Actions;
use App\Product\Domain\Requests\ProductRequest;
use App\Product\Domain\Services\ListMostSellingProductsService;
use App\Product\Responders\ProductResponder;

class ListMostSellingProductsAction 
{
    public function __construct(ProductResponder $responder, ListMostSellingProductsService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(ProductRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}