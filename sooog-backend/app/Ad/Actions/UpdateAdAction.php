<?php

namespace App\Ad\Actions;
use App\Ad\Domain\Requests\AdRequest;
use App\Ad\Domain\Services\UpdateAdService;
use App\Ad\Responders\AdResponder;

class UpdateAdAction 
{
    public function __construct(AdResponder $responder, UpdateAdService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(AdRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(array_merge($request->validated(), ["ad_id" => $id]))
        )->respond();
    }
}