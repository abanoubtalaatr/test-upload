<?php

namespace App\Refund\Domain\Services\RefundReason;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Refund\Domain\Models\RefundReason;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CreateRefundReasonService extends Service
{
    public function handle($data = []) 
    {
        try {
            // Begin Transaction
            DB::beginTransaction();
            $data['is_active'] = isset($data['is_active']) ? isset($data['is_active']) : 1;
	        $refund_reason = RefundReason::create($data);
	        // Commit Transaction
	        DB::commit();
	        return new GenericPayload($refund_reason, Response::HTTP_CREATED);
	        
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