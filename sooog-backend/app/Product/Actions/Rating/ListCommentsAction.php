<?php

namespace App\Product\Actions\Rating;

use App\Product\Domain\Requests\RatingFormRequest;
use App\Product\Domain\Services\Rating\ListCommentsService;
use App\Product\Responders\RatingResponder;

class ListCommentsAction 
{
    public function __construct(RatingResponder $responder, ListCommentsService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(RatingFormRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}