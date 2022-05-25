<?php

namespace App\PromoCode\Actions;
use App\PromoCode\Domain\Requests\PromoCodeRequest;
use App\PromoCode\Domain\Services\CreatePromoCodeService;
use App\PromoCode\Responders\PromoCodeResponder;

class CreatePromoCodeAction 
{
    public function __construct(PromoCodeResponder $responder, CreatePromoCodeService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(PromoCodeRequest $request) 
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}