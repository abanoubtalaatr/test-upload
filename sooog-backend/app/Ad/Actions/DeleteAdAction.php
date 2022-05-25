<?php

namespace App\Ad\Actions;
use App\Ad\Domain\Services\DeleteAdService;
use App\Ad\Responders\AdResponder;

class DeleteAdAction 
{
    public function __construct(AdResponder $responder, DeleteAdService $services) 
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