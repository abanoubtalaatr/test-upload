<?php

namespace App\Order\Actions;

use App\Order\Domain\Services\ExportOrdersToExcelService;
use App\Order\Responders\OrderResponder;

class ExportOrdersToExcelAction 
{
    public function __construct(OrderResponder $responder, ExportOrdersToExcelService $service) 
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