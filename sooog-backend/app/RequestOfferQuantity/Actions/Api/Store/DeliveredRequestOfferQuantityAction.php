<?php

namespace App\RequestOfferQuantity\Actions\Api\Store;

use App\RequestOfferQuantity\Domain\Requests\Store\DeliveredRequestOfferQuantityRequest;
use App\RequestOfferQuantity\Domain\Services\Store\DeliveredRequestOfferQuantityService;
use App\RequestOfferQuantity\Responders\ReplyRequestOfferQuantityResponder;

class DeliveredRequestOfferQuantityAction
{
    protected $responder = '';
    protected $service = '';

    public function __construct(ReplyRequestOfferQuantityResponder $responder, DeliveredRequestOfferQuantityService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(DeliveredRequestOfferQuantityRequest $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}
