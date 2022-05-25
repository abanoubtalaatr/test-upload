<?php

namespace App\Location\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Illuminate\Support\Arr;
use App\Location\Domain\Models\City;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class UpdateCityService extends Service
{
    public function handle($data = []) 
    {
        try {
            $city = City::findOrFail($data['city_id']);
        	$city->update($data);
            return new GenericPayload($city, Response::HTTP_CREATED);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
        
    }
}