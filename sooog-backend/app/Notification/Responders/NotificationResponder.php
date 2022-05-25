<?php

namespace App\Notification\Responders;

use App\Infrastructure\Responders\Responder;
use App\Infrastructure\Helpers\Traits\RESTApi;
use App\Infrastructure\Helpers\Traits\ApiPaginator;
use App\Notification\Domain\Resources\NotificationResource;
use Symfony\Component\HttpFoundation\Response;

class NotificationResponder extends Responder
{

    use ApiPaginator, RESTApi;

    public function respond()
    {
        if(!in_array($this->response->getStatus(), array_values(config('statuses.SUCCESS'))))
            return $this->sendError($this->response->getData());

        if($this->response->getStatus() == Response::HTTP_CREATED)
            return $this->sendJson(
                new NotificationResource($this->response->getData()),
                Response::HTTP_OK
            );

        if($this->response->getStatus() == Response::HTTP_OK)
            return $this->sendJson(
                NotificationResource::collection($this->response->getData()),
                $this->response->getStatus()
            );
        
        if($this->response->getStatus() == Response::HTTP_ACCEPTED)
            return $this->sendJson(  $this->getPaginatedResponse(
                $this->response->getData(),
                NotificationResource::collection($this->response->getData()))
                , Response::HTTP_OK
            );

        if($this->response->getStatus() == Response::HTTP_NO_CONTENT)
            return $this->sendJson($this->response->getData(), $this->response->getStatus());


        if($this->response->getStatus() == Response::HTTP_RESET_CONTENT)
            return $this->sendJson($this->response->getData(), Response::HTTP_OK);
    }
}
