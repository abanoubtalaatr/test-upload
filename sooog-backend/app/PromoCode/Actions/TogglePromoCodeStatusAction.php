<?php

namespace App\PromoCode\Actions;
use App\PromoCode\Domain\Services\TogglePromoCodeStatusService;
use App\PromoCode\Responders\PromoCodeResponder;

class TogglePromoCodeStatusAction 
{
    public function __construct(PromoCodeResponder $responder, TogglePromoCodeStatusService $services) 
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