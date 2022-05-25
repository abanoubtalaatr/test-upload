<?php

namespace App\BankAccount\Actions;
use App\BankAccount\Domain\Services\DeleteBankAccountService;
use App\BankAccount\Responders\BankAccountResponder;

class DeleteBankAccountAction 
{
    public function __construct(BankAccountResponder $responder, DeleteBankAccountService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(["account_id" => $id])
        )->respond();
    }
}