<?php

namespace App\Order\Actions\Transaction;
use App\Order\Domain\Requests\TransactionFormRequest;
use App\Order\Domain\Services\Transaction\ListUserTransactionsService;
use App\Order\Responders\TransactionResponder;
class ListUserTransactionsAction 
{
    public function __construct(TransactionResponder $responder, ListUserTransactionsService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(TransactionFormRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle()
        )->respond();
    }
}