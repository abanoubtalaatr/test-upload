<?php

namespace App\AppContent\Actions\API;
use App\AppContent\Domain\Services\API\DeleteFaqService;
use App\AppContent\Responders\API\DeleteFaqResponder;

class DeleteFaqAction 
{
    public function __construct(DeleteFaqResponder $responder, DeleteFaqService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(["faq_id" => $id])
        )->respond();
    }
}