<?php

namespace App\User\Actions;
use App\User\Domain\Services\GetTermsAndConditionsService;
use App\User\Responders\GetTermsAndConditionsResponder;

class GetTermsAndConditionsAction
{

    private $service, $responder;

    public function __construct(GetTermsAndConditionsResponder $responder, GetTermsAndConditionsService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke( )
    {
        return $this->responder->withResponse(
           $this->service->handle()
        )->respond();
    }
}
