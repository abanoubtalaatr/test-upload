<?php

namespace App\AppContent\Actions\ContactUs;

use App\AppContent\Domain\Services\ContactUs\ListContactUsService;
use App\AppContent\Responders\ContactUsResponder;

class ListContactUsAction 
{
    public function __construct(ContactUsResponder $responder, ListContactUsService $services) 
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