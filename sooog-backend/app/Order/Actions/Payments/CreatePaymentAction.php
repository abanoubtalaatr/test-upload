<?php

namespace App\Order\Actions\Payments;
use App\Order\Domain\Requests\PaymentRequest;
use App\Order\Domain\Services\Payments\CreatePaymentService;
use App\Order\Responders\PaymentResponder;

class CreatePaymentAction 
{
    public function __construct(PaymentResponder $responder, CreatePaymentService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(PaymentRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}