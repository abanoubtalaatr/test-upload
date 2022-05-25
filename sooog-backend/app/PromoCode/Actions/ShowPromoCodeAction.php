<?php

namespace App\PromoCode\Actions;
use App\PromoCode\Domain\Services\ShowPromoCodeService;
use App\PromoCode\Responders\PromoCodeResponder;

class ShowPromoCodeAction 
{
    public function __construct(PromoCodeResponder $responder, ShowPromoCodeService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(["promo_code_id" => $id])
        )->respond();
    }
}