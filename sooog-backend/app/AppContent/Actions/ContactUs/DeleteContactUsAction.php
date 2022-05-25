<?php

namespace App\AppContent\Actions\ContactUs;
use App\AppContent\Domain\Services\ContactUs\DeleteContactUsService;
use App\AppContent\Responders\ContactUsResponder;

class DeleteContactUsAction 
{
    public function __construct(ContactUsResponder $responder, DeleteContactUsService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(["contact_id" => $id])
        )->respond();
    }
}