<?php

namespace App\Refund\Domain\Services\RefundReason;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Refund\Domain\Models\RefundReason;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UpdateRefundReasonService extends Service
{
    public function handle($data = []) 
    {
        try {
            // Begin Transaction
            DB::beginTransaction();
            $refund_reason = RefundReason::findOrFail($data['reason_id']);
            $refund_reason->update($data);
            // Commit Transaction
            DB::commit();
            return new GenericPayload($refund_reason, Response::HTTP_CREATED);
            
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