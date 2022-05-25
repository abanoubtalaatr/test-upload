<?php

namespace App\BankAccount\Actions;
use App\BankAccount\Domain\Requests\BankAccountFormRequest;
use App\BankAccount\Domain\Services\UpdateBankAccountService;
use App\BankAccount\Responders\BankAccountResponder;

class UpdateBankAccountAction 
{
    public function __construct(BankAccountResponder $responder, UpdateBankAccountService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(BankAccountFormRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(array_merge($request->validated(), ["account_id" => $id]))
        )->respond();
    }
}