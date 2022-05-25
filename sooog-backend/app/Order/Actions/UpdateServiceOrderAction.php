<?php

namespace App\Order\Actions;
use App\Order\Domain\Requests\ServiceOrderRequest;
use App\Order\Domain\Services\UpdateServiceOrderService;
use App\Order\Responders\OrderResponder;

class UpdateServiceOrderAction 
{
    public function __construct(OrderResponder $responder, UpdateServiceOrderService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(ServiceOrderRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(array_merge($request->validated(), ["order_id" => $id]))
        )->respond();
    }
}