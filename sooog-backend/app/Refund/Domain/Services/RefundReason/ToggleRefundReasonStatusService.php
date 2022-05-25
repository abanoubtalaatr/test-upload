<?php

namespace App\Refund\Domain\Services\RefundReason;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Refund\Domain\Models\RefundReason;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ToggleRefundReasonStatusService extends Service
{
    public function handle($data = []) 
    {
        try {
            $refund_reason = RefundReason::findOrFail($data['reason_id']);
            $refund_reason->update([
                'is_active' => !$refund_reason->is_active
            ]);
            return new GenericPayload($refund_reason, Response::HTTP_CREATED);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
        

    }
}