<?php

namespace App\Offer\Actions;
use App\Offer\Domain\Requests\OfferRequest;
use App\Offer\Domain\Services\UpdateOfferService;
use App\Offer\Responders\OfferResponder;

class UpdateOfferAction 
{
    public function __construct(OfferResponder $responder, UpdateOfferService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(OfferRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(array_merge($request->validated(), ["offer_id" => $id]))
        )->respond();
    }
}