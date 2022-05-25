<?php

namespace App\Refund\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Refund\Domain\Models\Refund;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ShowRefundService extends Service
{
    public function handle($data = []) 
    {
        try {
            $refund = Refund::findOrFail($data['refund_id']);
            // if($refund->order->user_id != auth()->id() && (!auth()->guard('admin')->check() || !auth()->guard('store')->check() || !auth()->guard('center')->check()))
            //     return new GenericPayload(__('error.orders.userNotrefundOwner'), 422);
            // if(auth()->guard('admin')->check())
            //     return new GenericPayload($refund, 202);
            return new GenericPayload($refund, Response::HTTP_CREATED);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
    }
}