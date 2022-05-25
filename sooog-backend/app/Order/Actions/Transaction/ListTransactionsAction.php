<?php

namespace App\Order\Actions\Transaction;
use App\Order\Domain\Requests\TransactionFormRequest;
use App\Order\Domain\Services\Transaction\ListTransactionsService;
use App\Order\Responders\TransactionResponder;

class ListTransactionsAction 
{
    public function __construct(TransactionResponder $responder, ListTransactionsService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(TransactionFormRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(['user_id' => $id])
        )->respond();
    }
}