<?php

namespace App\Refund\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Refund\Domain\Models\Refund;
use App\Refund\Domain\Filters\RefundFilter;
use App\Refund\Domain\Exports\RefundsExport;
use Excel;
use Symfony\Component\HttpFoundation\Response;

class ExportRefundsToExcelService extends Service
{
    protected $refund, $filter;

    public function __construct(Refund $refund, RefundFilter $filter)
    {
        $this->refund = $refund;
        $this->filter = $filter;
    }

    public function handle($data = []) 
    {
        $store_id = auth()->user()->store_id;
        return new GenericPayload(
        	Excel::download(new RefundsExport(
                $this->refund->when($store_id, function($collection) use ($store_id){
                return $collection->ofStore($store_id);
            }), 
                $this->filter), 'refunds.xlsx'),
            Response::HTTP_RESET_CONTENT
        );
    }
}


    