<?php

namespace App\Order\Actions;
use App\Order\Domain\Requests\UpdateOrdersStatusFormRequest;
use App\Order\Domain\Services\UpdateOrdersStatusService;
use App\Order\Responders\OrderResponder;

class UpdateOrdersStatusAction 
{
    public function __construct(OrderResponder $responder, UpdateOrdersStatusService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(UpdateOrdersStatusFormRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}