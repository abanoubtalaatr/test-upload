<?php

namespace App\Ad\Actions;
use App\Ad\Domain\Requests\AdRequest;
use App\Ad\Domain\Services\CreateAdService;
use App\Ad\Responders\AdResponder;

class CreateAdAction 
{
    public function __construct(AdResponder $responder, CreateAdService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(AdRequest $request) 
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}