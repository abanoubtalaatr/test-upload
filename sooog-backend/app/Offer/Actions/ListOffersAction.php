<?php

namespace App\Offer\Actions;
use App\Offer\Domain\Requests\OfferRequest;
use App\Offer\Domain\Services\ListOffersService;
use App\Offer\Responders\OfferResponder;

class ListOffersAction 
{
    public function __construct(OfferResponder $responder, ListOffersService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(OfferRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request)
        )->respond();
    }
}