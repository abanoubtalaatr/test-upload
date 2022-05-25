<?php

namespace App\Product\Actions;
use App\Product\Domain\Requests\ProductRequest;
use App\Product\Domain\Services\ListProductsService;
use App\Product\Responders\ProductResponder;

class ListProductsAction 
{
    public function __construct(ProductResponder $responder, ListProductsService $service) 
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