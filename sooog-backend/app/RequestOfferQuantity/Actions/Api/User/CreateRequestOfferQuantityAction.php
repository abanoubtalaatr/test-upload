<?php

namespace App\RequestOfferQuantity\Actions\Api\User;

use App\RequestOfferQuantity\Domain\Requests\User\CreateRequestOfferQuantityRequest;
use App\RequestOfferQuantity\Domain\Services\User\CreateRequestOfferQuantityService;
use App\RequestOfferQuantity\Responders\RequestOfferQuantityResponder;

class CreateRequestOfferQuantityAction
{
    protected $responder = '';
    protected $service = '';

    public function __construct(RequestOfferQuantityResponder $responder, CreateRequestOfferQuantityService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(CreateRequestOfferQuantityRequest $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}
