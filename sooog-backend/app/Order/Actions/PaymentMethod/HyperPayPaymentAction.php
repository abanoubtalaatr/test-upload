<?php

namespace App\Order\Actions\PaymentMethod;
use App\Order\Domain\Services\PaymentMethod\HyperPayPaymentService;
use App\Order\Responders\HyperPayPaymentResponder;

class HyperPayPaymentAction
{
    public function __construct(HyperPayPaymentResponder $responder, HyperPayPaymentService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($for,$id)
    {
        return $this->responder->withResponse(
            $this->service->handle($for,$id)
        )->respond();
    }
}
