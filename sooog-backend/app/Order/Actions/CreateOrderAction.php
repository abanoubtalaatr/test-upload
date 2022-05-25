<?php

namespace App\Order\Actions;
use App\Order\Domain\Requests\OrderRequest;
use App\Order\Domain\Services\CreateOrderService;
use App\Order\Responders\OrderResponder;

class CreateOrderAction 
{
    public function __construct(OrderResponder $responder, CreateOrderService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(OrderRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}