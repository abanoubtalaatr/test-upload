<?php

namespace App\Location\Actions;
use App\Location\Domain\Requests\StateRequest;
use App\Location\Domain\Services\ListStatesService;
use App\Location\Responders\StateResponder;

class ListStatesAction 
{
    public function __construct(StateResponder $responder, ListStatesService $services) 
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