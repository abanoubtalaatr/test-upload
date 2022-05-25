<?php

namespace App\Location\Actions;
use App\Location\Domain\Requests\StateRequest;
use App\Location\Domain\Services\CreateStateService;
use App\Location\Responders\StateResponder;

class CreateStateAction 
{
    public function __construct(StateResponder $responder, CreateStateService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(StateRequest $request) 
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}