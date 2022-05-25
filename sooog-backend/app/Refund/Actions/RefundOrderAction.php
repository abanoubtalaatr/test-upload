<?php

namespace App\Refund\Actions;
use App\Refund\Domain\Services\RefundOrderService;
use App\Refund\Responders\RefundResponder;
use App\Refund\Domain\Requests\RefundFormRequest;

class RefundOrderAction 
{
    public function __construct(RefundResponder $responder, RefundOrderService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(RefundFormRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(array_merge($request->validated(), ["order_id" => $id]))
        )->respond();
    }
}