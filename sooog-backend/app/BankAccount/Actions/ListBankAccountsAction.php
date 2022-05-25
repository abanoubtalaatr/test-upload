<?php

namespace App\BankAccount\Actions;
;
use App\BankAccount\Domain\Requests\BankAccountFormRequest;
use App\BankAccount\Domain\Services\ListBankAccountsService;
use App\BankAccount\Responders\BankAccountResponder;

class ListBankAccountsAction 
{
    public function __construct(BankAccountResponder $responder, ListBankAccountsService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(BankAccountFormRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request)
        )->respond();
    }
}