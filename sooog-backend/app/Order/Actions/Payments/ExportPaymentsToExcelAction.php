<?php

namespace App\Order\Actions\Payments;
use App\Order\Domain\Services\Payments\ExportPaymentsToExcelService;
use App\Order\Responders\PaymentResponder;

class ExportPaymentsToExcelAction 
{
    public function __construct(PaymentResponder $responder, ExportPaymentsToExcelService $service) 
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