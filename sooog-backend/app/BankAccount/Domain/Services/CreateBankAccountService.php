<?php

namespace App\BankAccount\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\BankAccount\Domain\Models\BankAccount;
use Symfony\Component\HttpFoundation\Response;

class CreateBankAccountService extends Service
{
    public function handle($data = []) 
    {
        try {
            $data['is_active'] = isset($data['is_active']) ? isset($data['is_active']) : 1;
	        $account = BankAccount::create($data);
	        return new GenericPayload($account, Response::HTTP_CREATED);
	        
	    }catch (\Illuminate\Database\QueryException $ex) {
            // Rollback Transaction
            DB::rollback();
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        } catch (\PDOException $ex){
            // Rollback Transaction
            DB::rollback();
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        } catch (\Exception $ex) {
        	// Rollback Transaction
            DB::rollback();
            return new GenericPayload(
                 __('error.someThingWrong'), 422
            );
        }

    }
}