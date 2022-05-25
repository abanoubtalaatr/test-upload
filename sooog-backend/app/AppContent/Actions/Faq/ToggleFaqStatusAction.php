<?php

namespace App\AppContent\Actions\API;
use App\AppContent\Domain\Requests\FaqFormRequest;
use App\AppContent\Domain\Services\API\ToggleFaqStatusService;
use App\AppContent\Responders\API\UpdateFaqResponder;

class ToggleFaqStatusAction 
{
    public function __construct(UpdateFaqResponder $responder, ToggleFaqStatusService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(["faq_id" => $id])
        )->respond();
    }
}