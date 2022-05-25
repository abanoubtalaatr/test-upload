<?php

namespace App\Location\Actions;
use App\Location\Domain\Services\ToggleCityStatusService;
use App\Location\Responders\CityResponder;

class ToggleCityStatusAction 
{
    public function __construct(CityResponder $responder, ToggleCityStatusService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(["city_id" => $id])
        )->respond();
    }
}