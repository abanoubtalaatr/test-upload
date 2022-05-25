<?php

namespace App\Refund\Domain\Services\RefundReason;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Refund\Domain\Models\RefundReason;
use App\Refund\Domain\Filters\RefundReasonFilter;
use App\Refund\Domain\Exports\RefundReasonsExport;
use Excel;
use Symfony\Component\HttpFoundation\Response;

class ExportRefundReasonsToExcelService extends Service
{
    protected $reason, $filter;

    public function __construct(RefundReason $reason, RefundReasonFilter $filter)
    {
        $this->reason = $reason;
        $this->filter = $filter;
    }

    public function handle($data = []) 
    {
        return new GenericPayload(
        	Excel::download(new RefundReasonsExport($this->reason, $this->filter), 'refund_reasons.xlsx'),
            Response::HTTP_RESET_CONTENT
        );
    }
}


    