<?php

namespace App\Order\Actions\PaymentMethod;
use App\Order\Domain\Services\PaymentMethod\ListPaymentMethodsService;
use App\Order\Responders\PaymentMethodResponder;

class ListPaymentMethodsAction 
{
    public function __construct(PaymentMethodResponder $responder, ListPaymentMethodsService $service) 
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