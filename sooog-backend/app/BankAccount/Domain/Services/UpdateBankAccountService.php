<?php

namespace App\BankAccount\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\BankAccount\Domain\Models\BankAccount;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class UpdateBankAccountService extends Service
{
    public function handle($data = []) 
    {
        try {
            $account = BankAccount::findOrFail($data['account_id']);
            $account->update($data);
            return new GenericPayload($account, Response::HTTP_CREATED);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            // Rollback Transaction
            DB::rollback();
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            // Rollback Transaction
            DB::rollback();
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
    }
}