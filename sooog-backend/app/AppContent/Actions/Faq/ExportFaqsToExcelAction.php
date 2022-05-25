<?php

namespace App\AppContent\Actions\API;

use App\AppContent\Domain\Services\API\ExportFaqsToExcelService;
use App\AppContent\Responders\API\ExportFaqsToExcelResponder;

class ExportFaqsToExcelAction 
{
    public function __construct(ExportFaqsToExcelResponder $responder, ExportFaqsToExcelService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke() 
    {
        return $this->responder->withResponse(
            $this->services->handle()
        )->respond();
    }
}