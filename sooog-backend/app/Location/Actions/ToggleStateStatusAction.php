<?php

namespace App\Location\Actions;
use App\Location\Domain\Services\ToggleStateStatusService;
use App\Location\Responders\StateResponder;

class ToggleStateStatusAction 
{
    public function __construct(StateResponder $responder, ToggleStateStatusService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(["state_id" => $id])
        )->respond();
    }
}