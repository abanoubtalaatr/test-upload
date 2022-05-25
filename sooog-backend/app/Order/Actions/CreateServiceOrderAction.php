<?php

namespace App\Order\Actions;
use App\Order\Domain\Requests\ServiceOrderRequest;
use App\Order\Domain\Services\CreateServiceOrderService;
use App\Order\Responders\OrderResponder;

class CreateServiceOrderAction 
{
    public function __construct(OrderResponder $responder, CreateServiceOrderService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(ServiceOrderRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}