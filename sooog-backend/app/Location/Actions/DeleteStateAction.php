<?php

namespace App\Location\Actions;
use App\Location\Domain\Services\DeleteStateService;
use App\Location\Responders\StateResponder;
use App\Location\Domain\Models\State;

class DeleteStateAction 
{
    public function __construct(StateResponder $responder, DeleteStateService $services) 
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