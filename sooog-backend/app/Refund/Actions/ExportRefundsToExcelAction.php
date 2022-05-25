<?php

namespace App\Refund\Actions;

use App\Refund\Domain\Services\ExportRefundsToExcelService;
use App\Refund\Responders\RefundResponder;

class ExportRefundsToExcelAction 
{
    public function __construct(RefundResponder $responder, ExportRefundsToExcelService $service) 
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