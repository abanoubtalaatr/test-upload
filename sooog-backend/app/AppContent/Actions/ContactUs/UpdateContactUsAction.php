<?php

namespace App\AppContent\Actions\ContactUs;
use App\AppContent\Domain\Requests\ContactUsFormRequest;
use App\AppContent\Domain\Services\ContactUs\UpdateContactUsService;
use App\AppContent\Responders\ContactUsResponder;

class UpdateContactUsAction 
{
    public function __construct(ContactUsResponder $responder, UpdateContactUsService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(ContactUsFormRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(
                array_merge($request->validated(), ["contact_id" => $id])
            )
        )->respond();
    }
}