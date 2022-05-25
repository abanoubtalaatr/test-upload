<?php

namespace App\Ad\Actions;
use App\Ad\Domain\Services\ToggleAdStatusService;
use App\Ad\Responders\AdResponder;

class ToggleAdStatusAction 
{
    public function __construct(AdResponder $responder, ToggleAdStatusService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(["ad_id" => $id])
        )->respond();
    }
}