<?php

namespace App\Order\Actions;
use App\Order\Domain\Requests\OrderRequest;
use App\Order\Domain\Services\ListFinancialDuesService;
use App\Order\Responders\OrderResponder;

class ListFinancialDuesAction 
{
    public function __construct(OrderResponder $responder, ListFinancialDuesService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke() 
    {
        return $this->responder->withResponse(
            $this->service->handle(request()->all())
        )->respond();
    }
}