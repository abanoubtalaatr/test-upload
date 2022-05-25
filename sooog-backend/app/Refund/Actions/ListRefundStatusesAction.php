<?php

namespace App\Refund\Actions;
use App\Refund\Domain\Services\ListRefundStatusesService;
use App\Order\Responders\StatusResponder;

class ListRefundStatusesAction 
{
    public function __construct(StatusResponder $responder, ListRefundStatusesService $service) 
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