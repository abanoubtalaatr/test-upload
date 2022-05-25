<?php

namespace App\Order\Actions;
use App\Order\Domain\Services\DeleteOrderService;
use App\Order\Responders\OrderResponder;

class DeleteOrderAction 
{
    public function __construct(OrderResponder $responder, DeleteOrderService $service) 
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