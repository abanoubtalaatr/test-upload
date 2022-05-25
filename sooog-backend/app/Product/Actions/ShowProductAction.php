<?php

namespace App\Product\Actions;
use App\Product\Domain\Services\ShowProductService;
use App\Product\Responders\ProductResponder;

class ShowProductAction 
{
    public function __construct(ProductResponder $responder, ShowProductService $service) 
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