<?php

namespace App\AppContent\Actions\ContactUs;
use App\AppContent\Domain\Services\ContactUs\CreateContactUsService;
use App\AppContent\Responders\ContactUsResponder;
use App\AppContent\Domain\Requests\ContactUsFormRequest;

class CreateContactUsAction
{

    public function __construct(ContactUsResponder $responder, CreateContactUsService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

     public function __invoke(ContactUsFormRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}
