<?php

namespace App\RequestOfferQuantity\Actions\Api\Store;

use App\RequestOfferQuantity\Domain\Services\Store\ExportRequestOfferQuantityService;
use App\RequestOfferQuantity\Responders\RequestOfferQuantityResponder;

class ExportRequestOfferQuantityAction
{
    protected $responder = '';
    protected $service = '';

    public function __construct(RequestOfferQuantityResponder $responder, ExportRequestOfferQuantityService $service)
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
