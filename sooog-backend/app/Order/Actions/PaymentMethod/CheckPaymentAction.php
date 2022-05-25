<?php

namespace App\Order\Actions\PaymentMethod;
use App\Order\Domain\Services\PaymentMethod\CheckPaymentService;
use App\Order\Responders\CheckPaymentResponder;

class CheckPaymentAction
{
    public function __construct(CheckPaymentResponder $responder, CheckPaymentService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke() 
    {
        return $this->responder->withResponse(
            $this->service->handle(request()->all())
        )->respond();
    }
}
