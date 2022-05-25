<?php

namespace App\Product\Actions;
use App\Product\Domain\Requests\ProductRequest;
use App\Product\Domain\Services\ListMost10SellingForStoreProductsService;
use App\Product\Responders\MostSellingProductResponder;

class ListMost10SellingForStoreProductsAction
{
    public function __construct(MostSellingProductResponder $responder, ListMost10SellingForStoreProductsService $service)
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
