<?php

namespace App\Store\Actions;

use App\Store\Domain\Services\ExportStoresToExcelService;
use App\Store\Responders\StoreResponder;

class ExportStoresToExcelAction 
{
    public function __construct(StoreResponder $responder, ExportStoresToExcelService $services) 
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