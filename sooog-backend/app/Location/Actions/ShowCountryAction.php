<?php

namespace App\Location\Actions;
use App\Location\Domain\Services\ShowCountryService;
use App\Location\Responders\CountryResponder;
use App\Location\Domain\Models\Country;

class ShowCountryAction 
{
    public function __construct(CountryResponder $responder, ShowCountryService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(["country_id" => $id])
        )->respond();
    }
}