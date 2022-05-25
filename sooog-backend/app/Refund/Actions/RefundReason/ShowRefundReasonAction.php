<?php

namespace App\Refund\Actions\RefundReason;
use App\Refund\Domain\Services\RefundReason\ShowRefundReasonService;
use App\Refund\Responders\RefundReasonResponder;

class ShowRefundReasonAction 
{
    public function __construct(RefundReasonResponder $responder, ShowRefundReasonService $service) 
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