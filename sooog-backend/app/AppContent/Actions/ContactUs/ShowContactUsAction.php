<?php

namespace App\AppContent\Actions\ContactUs;
use App\AppContent\Domain\Requests\ContactUsFormRequest;
use App\AppContent\Domain\Services\ContactUs\ShowContactUsService;
use App\AppContent\Responders\ContactUsResponder;

class ShowContactUsAction 
{
    public function __construct(ContactUsResponder $responder, ShowContactUsService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(
                ["contact_id" => $id]
            )
        )->respond();
    }
}