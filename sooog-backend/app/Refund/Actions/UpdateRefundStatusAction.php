<?php

namespace App\Refund\Actions;
use App\Refund\Domain\Requests\RefundFormRequest;
use App\Refund\Domain\Services\UpdateRefundStatusService;
use App\Refund\Responders\RefundResponder;

class UpdateRefundStatusAction 
{
    public function __construct(RefundResponder $responder, UpdateRefundStatusService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(RefundFormRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(array_merge($request->validated(), ["refund_id" => $id]))
        )->respond();
    }
}