<?php

namespace App\Ad\Actions;
use App\Ad\Domain\Requests\AdRequest;
use App\Ad\Domain\Services\ListAdsService;
use App\Ad\Responders\AdResponder;

class ListAdsAction 
{
    public function __construct(AdResponder $responder, ListAdsService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(AdRequest $request) 
    {
        return $this->responder->withResponse(
            $this->services->handle($request)
        )->respond();
    }
}