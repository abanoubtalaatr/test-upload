<?php

namespace App\Location\Actions;
use App\Location\Domain\Requests\CityRequest;
use App\Location\Domain\Services\ListCitiesService;
use App\Location\Responders\CityResponder;

class ListCitiesAction 
{
    public function __construct(CityResponder $responder, ListCitiesService $services) 
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