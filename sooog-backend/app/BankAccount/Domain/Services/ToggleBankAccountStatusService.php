<?php

namespace App\BankAccount\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\BankAccount\Domain\Models\BankAccount;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ToggleBankAccountStatusService extends Service
{
    public function handle($data = []) 
    {
        try {
            $account = BankAccount::findOrFail($data['account_id']);
            if($account->is_active && count($account->orders()->get()) > 0)
                return new GenericPayload(
                    __('error.cannotDeactivate'), 422
                );

            $account->update([
                'is_active' => !$account->is_active
            ]);
            return new GenericPayload($account, Response::HTTP_CREATED);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
        

    }
}