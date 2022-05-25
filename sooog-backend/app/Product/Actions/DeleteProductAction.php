<?php

namespace App\Product\Actions;
use App\Product\Domain\Services\DeleteProductService;
use App\Product\Responders\ProductResponder;

class DeleteProductAction 
{
    public function __construct(ProductResponder $responder, DeleteProductService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(["product_id" => $id])
        )->respond();
    }
}