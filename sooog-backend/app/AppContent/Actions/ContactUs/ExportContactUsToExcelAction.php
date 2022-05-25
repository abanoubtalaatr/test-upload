<?php

namespace App\AppContent\Actions\ContactUs;

use App\AppContent\Domain\Services\ContactUs\ExportContactUsToExcelService;
use App\AppContent\Responders\ContactUsResponder;

class ExportContactUsToExcelAction 
{
    public function __construct(ContactUsResponder $responder, ExportContactUsToExcelService $services) 
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