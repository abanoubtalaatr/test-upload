<?php

namespace App\Location\Actions;
use App\Location\Domain\Requests\CityRequest;
use App\Location\Domain\Services\CreateCityService;
use App\Location\Responders\CityResponder;

class CreateCityAction 
{
    public function __construct(CityResponder $responder, CreateCityService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(CityRequest $request) 
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}