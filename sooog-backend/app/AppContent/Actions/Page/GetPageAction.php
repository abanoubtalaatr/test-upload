<?php

namespace App\AppContent\Actions\Page;
use App\AppContent\Domain\Services\Page\GetPageService;
use App\AppContent\Responders\PageResponder;

class GetPageAction
{

    private $service, $responder;

    public function __construct(PageResponder $responder, GetPageService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($slug)
    {
        return $this->responder->withResponse(
           $this->service->handle(["slug" => $slug])
        )->respond();
    }
}
