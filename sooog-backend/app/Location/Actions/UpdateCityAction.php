<?php

namespace App\Location\Actions;
use App\Location\Domain\Requests\CityRequest;
use App\Location\Domain\Services\UpdateCityService;
use App\Location\Responders\CityResponder;

class UpdateCityAction 
{
    public function __construct(CityResponder $responder, UpdateCityService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(CityRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(array_merge($request->validated(), ["city_id" => $id]))
        )->respond();
    }
}