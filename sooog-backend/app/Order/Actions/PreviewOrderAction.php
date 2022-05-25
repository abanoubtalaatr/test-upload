<?php

namespace App\Order\Actions;
use App\Order\Domain\Requests\PreviewOrderRequest;
use App\Order\Domain\Services\PreviewOrderService;
use App\Order\Responders\OrderResponder;

class PreviewOrderAction 
{
    public function __construct(OrderResponder $responder, PreviewOrderService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(PreviewOrderRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}