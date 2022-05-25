<?php

namespace App\Order\Actions;
use App\Order\Domain\Requests\OrderRequest;
use App\Order\Domain\Services\UpdateOrderService;
use App\Order\Responders\OrderResponder;

class UpdateOrderAction 
{
    public function __construct(OrderResponder $responder, UpdateOrderService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(OrderRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(array_merge($request->validated(), ["order_id" => $id]))
        )->respond();
    }
}