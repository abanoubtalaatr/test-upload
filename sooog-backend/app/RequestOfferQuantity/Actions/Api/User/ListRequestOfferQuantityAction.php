<?php

namespace App\RequestOfferQuantity\Actions\Api\User;

use App\RequestOfferQuantity\Domain\Requests\User\ListRequestOfferQuantityRequest;
use App\RequestOfferQuantity\Domain\Services\User\ListRequestOfferQuantityService;
use App\RequestOfferQuantity\Responders\RequestOfferQuantityResponder;

class ListRequestOfferQuantityAction
{
    protected $responder = '';
    protected $service = '';

    public function __construct(RequestOfferQuantityResponder $responder, ListRequestOfferQuantityService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(ListRequestOfferQuantityRequest $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}
