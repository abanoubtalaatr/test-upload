<?php

namespace App\Refund\Actions;
use App\Refund\Domain\Requests\RefundFormRequest;
use App\Refund\Domain\Services\CreateRefundService;
use App\Refund\Responders\RefundResponder;

class CreateRefundAction 
{
    public function __construct(RefundResponder $responder, CreateRefundService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(RefundFormRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}