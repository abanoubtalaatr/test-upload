<?php

namespace App\Order\Actions\Transaction;
use App\Order\Domain\Requests\TransactionFormRequest;
use App\Order\Domain\Services\Transaction\CreateTransactionService;
use App\Order\Responders\TransactionResponder;
class CreateTransactionAction 
{
    public function __construct(TransactionResponder $responder, CreateTransactionService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(TransactionFormRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(array_merge($request->validated(), ['user_id' => $id]))
        )->respond();
    }
}