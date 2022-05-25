<?php

namespace App\Product\Actions\Rating;

use App\Product\Domain\Services\Rating\UpdateCommentStatusService;
use App\Product\Responders\RatingResponder;

class UpdateCommentStatusAction 
{
    public function __construct(RatingResponder $responder, UpdateCommentStatusService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(['rating_id' => $id])
        )->respond();
    }
}