<?php

namespace App\Refund\Actions\RefundReason;
use App\Refund\Domain\Services\RefundReason\ToggleRefundReasonStatusService;
use App\Refund\Responders\RefundReasonResponder;

class ToggleRefundReasonStatusAction 
{
    public function __construct(RefundReasonResponder $responder, ToggleRefundReasonStatusService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(["reason_id" => $id])
        )->respond();
    }
}