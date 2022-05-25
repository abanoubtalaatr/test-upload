<?php

namespace App\BankAccount\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\BankAccount\Domain\Models\BankAccount;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class DeleteBankAccountService extends Service
{
    public function handle($data = []) 
    {
        try {
            $account = BankAccount::findOrFail($data['account_id']);
            if(count($account->orders()->get()) > 0)
                return new GenericPayload(
                    __('error.cannotDelete'), 422
                );
            $account->delete();
            return new GenericPayload(['message' => __('success.deletedSuccessfuly')], Response::HTTP_NO_CONTENT);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
        

    }
}