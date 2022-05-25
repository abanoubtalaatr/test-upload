<?php

namespace App\BankAccount\Actions;
use App\BankAccount\Domain\Services\ToggleBankAccountStatusService;
use App\BankAccount\Responders\BankAccountResponder;

class ToggleBankAccountStatusAction 
{
    public function __construct(BankAccountResponder $responder, ToggleBankAccountStatusService $service) 
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