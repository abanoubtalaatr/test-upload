<?php

namespace App\Order\Actions;
use App\Order\Domain\Services\ListOrderStatusesService;
use App\Order\Responders\StatusResponder;

class ListOrderStatusesAction 
{
    public function __construct(StatusResponder $responder, ListOrderStatusesService $service) 
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