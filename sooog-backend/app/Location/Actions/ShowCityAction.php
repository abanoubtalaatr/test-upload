<?php

namespace App\Location\Actions;
use App\Location\Domain\Services\ShowCityService;
use App\Location\Responders\CityResponder;

class ShowCityAction 
{
    public function __construct(CityResponder $responder, ShowCityService $services) 
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