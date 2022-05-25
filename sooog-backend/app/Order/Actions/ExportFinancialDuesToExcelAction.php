<?php

namespace App\Order\Actions;

use App\Order\Domain\Services\ExportFinancialDuesToExcelService;
use App\Order\Responders\OrderResponder;

class ExportFinancialDuesToExcelAction 
{
    public function __construct(OrderResponder $responder, ExportFinancialDuesToExcelService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke() 
    {
        return $this->responder->withResponse(
            $this->service->handle()
        )->respond();
    }
}