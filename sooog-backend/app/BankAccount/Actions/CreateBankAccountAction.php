<?php

namespace App\BankAccount\Actions;
use App\BankAccount\Domain\Requests\BankAccountFormRequest;
use App\BankAccount\Domain\Services\CreateBankAccountService;
use App\BankAccount\Responders\BankAccountResponder;

class CreateBankAccountAction 
{
    public function __construct(BankAccountResponder $responder, CreateBankAccountService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(BankAccountFormRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}