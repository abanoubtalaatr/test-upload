<?php

namespace App\Location\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Location\Domain\Models\Country;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class CreateCountryService extends Service
{
    public function handle($data = []) 
    {
        $country = Country::create($data);
        return new GenericPayload($country, Response::HTTP_CREATED);

    }
}