<?php

namespace App\Brand\Actions;
use App\Brand\Domain\Services\ToggleBrandStatusService;
use App\Brand\Responders\BrandResponder;

class ToggleBrandStatusAction 
{
    public function __construct(BrandResponder $responder, ToggleBrandStatusService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(["brand_id" => $id])
        )->respond();
    }
}