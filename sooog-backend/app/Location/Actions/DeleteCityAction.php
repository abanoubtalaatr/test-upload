<?php

namespace App\Location\Actions;
use App\Location\Domain\Services\DeleteCityService;
use App\Location\Responders\CityResponder;

class DeleteCityAction 
{
    public function __construct(CityResponder $responder, DeleteCityService $services) 
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