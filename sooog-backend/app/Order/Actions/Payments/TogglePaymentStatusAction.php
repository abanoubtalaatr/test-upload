<?php

namespace App\Order\Actions\Payments;
use App\Order\Domain\Requests\PaymentRequest;
use App\Order\Domain\Services\Payments\ListPaymentsService;
use App\Order\Domain\Services\Payments\TogglePaymentStatusService;
use App\Order\Responders\PaymentMethodResponder;
use App\Order\Responders\PaymentResponder;

class TogglePaymentStatusAction
{
    public function __construct(PaymentMethodResponder $responder, TogglePaymentStatusService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id)
    {
        return $this->responder->withResponse(
            $this->service->handle($id)
        )->respond();
    }
}
