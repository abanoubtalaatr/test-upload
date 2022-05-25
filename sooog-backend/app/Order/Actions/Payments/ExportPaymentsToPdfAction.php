<?php

namespace App\Order\Actions\Payments;
use App\Order\Domain\Services\Payments\ExportPaymentsToPdfService;
use App\Order\Responders\PaymentResponder;

class ExportPaymentsToPdfAction 
{
    public function __construct(PaymentResponder $responder, ExportPaymentsToPdfService $service) 
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