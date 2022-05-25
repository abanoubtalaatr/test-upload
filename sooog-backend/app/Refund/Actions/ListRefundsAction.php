<?php

namespace App\Refund\Actions;
use App\Refund\Domain\Requests\RefundFormRequest;
use App\Refund\Domain\Services\ListRefundsService;
use App\Refund\Responders\RefundResponder;

class ListRefundsAction 
{
    public function __construct(RefundResponder $responder, ListRefundsService $service) 
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