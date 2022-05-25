<?php

namespace App\Refund\Domain\Services\RefundReason;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Refund\Domain\Models\RefundReason;
use App\Refund\Domain\Filters\RefundReasonFilter;
use Symfony\Component\HttpFoundation\Response;

class ListRefundReasonsService extends Service
{
    protected $RefundReason, $filter;

    public function __construct(RefundReason $reason, RefundReasonFilter $filter)
    {
        $this->reason = $reason;
        $this->filter = $filter;
    }

    public function handle($data = [])
    {
        $order = isset($data['orderBy']) ? $data['orderBy'] : 'id';
        $order_type = isset($data['orderType']) ? $data['orderType'] : 'DESC';
        $limit = isset($data['per_page']) ? $data['per_page'] : config('app.pagination_limit');
        $active = isset($data['active']) ? $data['active'] : 1;
        $is_detailed = isset($data['is_detailed']) ? $data['is_detailed'] : 1;
        if($is_detailed == 'true')
            $is_detailed = 1;
        if( !isset($data['is_paginated']) || $data['is_paginated'] == 0 ):
            $reasons = $this->reason->active(1)->filter($this->filter)->orderBy($order, $order_type)->get();
            return new GenericPayload($reasons, Response::HTTP_OK);
        else:
            $reasons = $this->reason
                ->where('type', '!=', 'other')
                ->filter($this->filter)
                ->when(isset($data['active']), function($collection) use ($active){
                    return $collection->active($active);
                })->paginate($limit);

                return new GenericPayload($reasons, Response::HTTP_ACCEPTED);
        endif;
    }
}
