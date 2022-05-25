<?php

namespace App\Refund\Domain\Services\RefundReason;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Refund\Domain\Models\RefundReason;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class DeleteRefundReasonService extends Service
{
    public function handle($data = []) 
    {
        try {
            $refund_reason = RefundReason::findOrFail($data['reason_id']);
            if(count($refund_reason->refunds()->get()) > 0)
        		return new GenericPayload(
                    __('error.cannotDelete'), 422
                );
            if($refund_reason->type == 'other')
                return new GenericPayload(
                    __('error.cannotDelete'), 422
                );
            $refund_reason->delete();
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