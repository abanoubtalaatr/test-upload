<?php

namespace App\Refund\Actions;
use App\Refund\Domain\Services\ShowRefundService;
use App\Refund\Responders\RefundResponder;

class ShowRefundAction 
{
    public function __construct(RefundResponder $responder, ShowRefundService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(["refund_id" => $id])
        )->respond();
    }
}