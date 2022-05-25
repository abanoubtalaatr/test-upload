<?php

namespace App\Product\Actions;
use App\Product\Domain\Services\DeleteProductService;
use App\Product\Domain\Services\DeleteProductUnitService;
use App\Product\Responders\ProductResponder;

class DeleteProductUnitAction
{
    public function __construct(ProductResponder $responder, DeleteProductUnitService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(["product_unit_id" => $id])
        )->respond();
    }
}
