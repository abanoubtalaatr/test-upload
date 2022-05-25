<?php

namespace App\Product\Actions\Rating;

use App\Product\Domain\Requests\RatingFormRequest;
use App\Product\Domain\Services\Rating\DeleteRateService;
use App\Product\Responders\RatingResponder;

class DeleteRateAction 
{
    public function __construct(RatingResponder $responder, DeleteRateService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(RatingFormRequest $request) 
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}