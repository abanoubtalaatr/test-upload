<?php

namespace App\PromoCode\Actions;
use App\PromoCode\Domain\Requests\PromoCodeRequest;
use App\PromoCode\Domain\Services\UpdatePromoCodeService;
use App\PromoCode\Responders\PromoCodeResponder;

class UpdatePromoCodeAction 
{
    public function __construct(PromoCodeResponder $responder, UpdatePromoCodeService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(PromoCodeRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(array_merge($request->validated(), ["promo_code_id" => $id]))
        )->respond();
    }
}