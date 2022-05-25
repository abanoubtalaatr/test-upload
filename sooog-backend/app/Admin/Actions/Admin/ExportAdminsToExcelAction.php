<?php

namespace App\Admin\Actions\Admin;

use App\Admin\Domain\Services\Admin\ExportAdminsToExcelService;
use App\Admin\Responders\AdminResponder;

class ExportAdminsToExcelAction 
{
    public function __construct(AdminResponder $responder, ExportAdminsToExcelService $service) 
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