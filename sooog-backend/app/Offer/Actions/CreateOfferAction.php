<?php

namespace App\Offer\Actions;
use App\Offer\Domain\Requests\OfferRequest;
use App\Offer\Domain\Services\CreateOfferService;
use App\Offer\Responders\OfferResponder;

class CreateOfferAction 
{
    public function __construct(OfferResponder $responder, CreateOfferService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(OfferRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}