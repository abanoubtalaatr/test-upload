<?php

namespace App\PromoCode\Actions;

use App\PromoCode\Domain\Services\ExportPromoCodesToExcelService;
use App\PromoCode\Responders\PromoCodeResponder;

class ExportPromoCodesToExcelAction 
{
    public function __construct(PromoCodeResponder $responder, ExportPromoCodesToExcelService $service) 
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