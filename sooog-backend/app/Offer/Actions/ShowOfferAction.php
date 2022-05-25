<?php

namespace App\Offer\Actions;
use App\Offer\Domain\Services\ShowOfferService;
use App\Offer\Responders\OfferResponder;

class ShowOfferAction 
{
    public function __construct(OfferResponder $responder, ShowOfferService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(["offer_id" => $id])
        )->respond();
    }
}