<?php

namespace App\Refund\Domain\Services\RefundReason;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Refund\Domain\Models\RefundReason;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ShowRefundReasonService extends Service
{
    public function handle($data = []) 
    {
        try {
            $refund_reason = RefundReason::findOrFail($data['reason_id']);
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