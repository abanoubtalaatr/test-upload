<?php

namespace App\PromoCode\Actions;
use App\PromoCode\Domain\Requests\PromoCodeRequest;
use App\PromoCode\Domain\Services\ListPromoCodesService;
use App\PromoCode\Responders\PromoCodeResponder;

class ListPromoCodesAction 
{
    public function __construct(PromoCodeResponder $responder, ListPromoCodesService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(PromoCodeRequest $request) 
    {
        return $this->responder->withResponse(
            $this->services->handle($request)
        )->respond();
    }
}