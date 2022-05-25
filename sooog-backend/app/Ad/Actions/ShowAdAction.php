<?php

namespace App\Ad\Actions;
use App\Ad\Domain\Services\ShowAdService;
use App\Ad\Responders\AdResponder;

class ShowAdAction 
{
    public function __construct(AdResponder $responder, ShowAdService $services) 
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