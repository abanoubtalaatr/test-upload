<?php

namespace App\BankAccount\Actions;
use App\BankAccount\Domain\Services\ShowBankAccountService;
use App\BankAccount\Responders\BankAccountResponder;

class ShowBankAccountAction 
{
    public function __construct(BankAccountResponder $responder, ShowBankAccountService $service) 
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