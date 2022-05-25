<?php

namespace App\Order\Actions;
use App\Order\Domain\Services\ShowOrderService;
use App\Order\Responders\OrderResponder;

class ShowOrderAction 
{
    public function __construct(OrderResponder $responder, ShowOrderService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(["order_id" => $id])
        )->respond();
    }
}