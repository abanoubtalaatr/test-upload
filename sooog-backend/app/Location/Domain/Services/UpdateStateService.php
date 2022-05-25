<?php

namespace App\Location\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Illuminate\Support\Arr;
use App\Location\Domain\Models\State;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class UpdateStateService extends Service
{
    public function handle($data = []) 
    {        
        try {
            $state = State::findOrFail($data['state_id']);
        	$state->update($data);
            return new GenericPayload($state, Response::HTTP_CREATED);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
    }
}