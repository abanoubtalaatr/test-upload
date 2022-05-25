<?php

namespace App\AppContent\Actions\ContactUs;

use App\AppContent\Domain\Services\ContactUs\ListContactTypesService;
use App\AppContent\Responders\ContactUsResponder;

class ListContactTypesAction 
{
    public function __construct(ContactUsResponder $responder, ListContactTypesService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke() 
    {
        return $this->responder->withResponse(
            $this->services->handle()
        )->respond();
    }
}