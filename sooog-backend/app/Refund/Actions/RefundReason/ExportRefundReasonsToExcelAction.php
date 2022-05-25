<?php

namespace App\Refund\Actions\RefundReason;

use App\Refund\Domain\Services\RefundReason\ExportRefundReasonsToExcelService;
use App\Refund\Responders\RefundReasonResponder;

class ExportRefundReasonsToExcelAction 
{
    public function __construct(RefundReasonResponder $responder, ExportRefundReasonsToExcelService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke() 
    {
        return $this->responder->withResponse(
            $this->service->handle()
        )->respond();
    }
}