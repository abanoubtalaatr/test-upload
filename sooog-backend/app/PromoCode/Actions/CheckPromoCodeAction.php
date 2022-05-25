<?php

namespace App\PromoCode\Actions;
use App\PromoCode\Domain\Requests\CheckPromoCodeRequest;
use App\PromoCode\Domain\Services\CheckPromoCodeService;
use App\PromoCode\Responders\PromoCodeResponder;

class CheckPromoCodeAction 
{
    public function __construct(PromoCodeResponder $responder, CheckPromoCodeService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(CheckPromoCodeRequest $request) 
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}