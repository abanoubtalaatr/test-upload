<?php

namespace App\Order\Actions\Payments;
use App\Order\Domain\Services\Payments\ShowPaymentService;
use App\Order\Responders\PaymentResponder;

class ShowPaymentAction 
{
    public function __construct(PaymentResponder $responder, ShowPaymentService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(["payment_id" => $id])
        )->respond();
    }
}