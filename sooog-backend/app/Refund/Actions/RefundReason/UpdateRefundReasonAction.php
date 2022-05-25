<?php

namespace App\Refund\Actions\RefundReason;
use App\Refund\Domain\Requests\RefundReasonFormRequest;
use App\Refund\Domain\Services\RefundReason\UpdateRefundReasonService;
use App\Refund\Responders\RefundReasonResponder;

class UpdateRefundReasonAction 
{
    public function __construct(RefundReasonResponder $responder, UpdateRefundReasonService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(RefundReasonFormRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(array_merge($request->validated(), ["reason_id" => $id]))
        )->respond();
    }
}