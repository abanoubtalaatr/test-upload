<?php

namespace App\Chat\Responders;

use App\Chat\Domain\Resources\ChatResource;
use App\Infrastructure\Responders\Responder;
use App\Infrastructure\Helpers\Traits\RESTApi;
use App\Infrastructure\Helpers\Traits\ApiPaginator;
use Symfony\Component\HttpFoundation\Response;

class ChatResponder extends Responder
{

    use ApiPaginator, RESTApi;

    public function respond()
    {
        if(!in_array($this->response->getStatus(), array_values(config('statuses.SUCCESS'))))
            return $this->sendError($this->response->getData());

        if($this->response->getStatus() == Response::HTTP_CREATED)
            return $this->sendJson(
                new ChatResource($this->response->getData()),
                Response::HTTP_OK
            );

        if($this->response->getStatus() == Response::HTTP_OK)
            return $this->sendJson(
                ChatResource::collection($this->response->getData()),
                $this->response->getStatus()
            );
        
        if($this->response->getStatus() == Response::HTTP_ACCEPTED)
            return $this->sendJson(  $this->getPaginatedResponse(
                $this->response->getData(),
                ChatResource::collection($this->response->getData()))
                , Response::HTTP_OK
            );

        if($this->response->getStatus() == Response::HTTP_NO_CONTENT)
            return $this->sendJson($this->response->getData(), $this->response->getStatus());


        if($this->response->getStatus() == Response::HTTP_RESET_CONTENT)
            return $this->sendJson($this->response->getData(), Response::HTTP_OK);
    }
}
