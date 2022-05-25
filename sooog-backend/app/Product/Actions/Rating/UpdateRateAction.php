<?php

namespace App\Product\Actions\Rating;

use App\Product\Domain\Requests\RatingFormRequest;
use App\Product\Domain\Services\Rating\UpdateRateService;
use App\Product\Responders\RatingResponder;

class UpdateRateAction 
{
    public function __construct(RatingResponder $responder, UpdateRateService $services) 
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