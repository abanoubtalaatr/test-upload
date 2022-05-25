<?php

namespace App\Location\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Location\Domain\Models\State;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class DeleteStateService extends Service
{
    public function handle($data = []) 
    {        
        try {
            $state = State::findOrFail($data['state_id']);
            if(count($state->cities()->where('is_active',1)->get()) > 0)
                return new GenericPayload(
                    __('error.cannotDelete'), 422
                );

            if(count($state->addresses()->get()) > 0)
                return new GenericPayload(
                    __('error.cannotDelete'), 422
                );

        	$state->delete();
            return new GenericPayload(['message' => __('success.deletedSuccessfuly')], Response::HTTP_NO_CONTENT);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
    }
}