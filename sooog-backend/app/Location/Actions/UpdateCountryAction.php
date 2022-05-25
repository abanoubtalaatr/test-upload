<?php

namespace App\Location\Actions;
use App\Location\Domain\Requests\CountryRequest;
use App\Location\Domain\Services\UpdateCountryService;
use App\Location\Responders\CountryResponder;
use App\Location\Domain\Models\Country;

class UpdateCountryAction 
{
    public function __construct(CountryResponder $responder, UpdateCountryService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(CountryRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(array_merge($request->validated(), ["country_id" => $id]))
        )->respond();
    }
}