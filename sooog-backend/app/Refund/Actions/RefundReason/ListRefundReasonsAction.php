<?php

namespace App\Refund\Actions\RefundReason;
use App\Refund\Domain\Requests\RefundReasonFormRequest;
use App\Refund\Domain\Services\RefundReason\ListRefundReasonsService;
use App\Refund\Responders\RefundReasonResponder;

class ListRefundReasonsAction 
{
    public function __construct(RefundReasonResponder $responder, ListRefundReasonsService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(RefundReasonFormRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request)
        )->respond();
    }
}