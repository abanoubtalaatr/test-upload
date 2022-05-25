<?php

namespace App\AppContent\Actions\API;
use App\AppContent\Domain\Requests\FaqFormRequest;
use App\AppContent\Domain\Services\API\ShowFaqService;
use App\AppContent\Responders\API\UpdateFaqResponder;

class ShowFaqAction 
{
    public function __construct(UpdateFaqResponder $responder, ShowFaqService $service) 
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