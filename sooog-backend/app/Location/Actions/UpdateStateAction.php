<?php

namespace App\Location\Actions;
use App\Location\Domain\Requests\StateRequest;
use App\Location\Domain\Services\UpdateStateService;
use App\Location\Responders\StateResponder;

class UpdateStateAction 
{
    public function __construct(StateResponder $responder, UpdateStateService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(StateRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(array_merge($request->validated(), ["state_id" => $id]))
        )->respond();
    }
}