<?php

namespace App\RequestOfferQuantity\Responders;

use App\Infrastructure\Helpers\Traits\ApiPaginator;
use App\Infrastructure\Helpers\Traits\RESTApi;
use App\Infrastructure\Responders\Responder;
use App\RequestOfferQuantity\Domain\Resources\ReplyRequestOfferQuantityResource;
use App\RequestOfferQuantity\Domain\Resources\RequestOfferQuantityResource;
use Symfony\Component\HttpFoundation\Response;

class ReplyRequestOfferQuantityResponder extends Responder
{
    use RESTApi, ApiPaginator;

    public function respond()
    {
        if (!in_array($this->response->getStatus(), array_values(config('statuses.SUCCESS'))))
            return $this->sendError($this->response->getData());

        if ($this->response->getStatus() == Response::HTTP_CREATED) {
            return $this->sendJson(
                new ReplyRequestOfferQuantityResource($this->response->getData()),
                Response::HTTP_OK
            );
        }

        if($this->response->getStatus() == Response::HTTP_PARTIAL_CONTENT)
            return $this->sendJson(
                new ReplyRequestOfferQuantityResource($this->response->getData()),
                Response::HTTP_OK
            );


        if ($this->response->getStatus() == Response::HTTP_OK)
                return $this->sendJson(
                    ReplyRequestOfferQuantityResource::collection($this->response->getData()),
                    $this->response->getStatus()
                );

        if ($this->response->getStatus() == Response::HTTP_ACCEPTED)

            return $this->sendJson(
                $this->getPaginatedResponse(
                    $this->response->getData(),
                    ReplyRequestOfferQuantityResource::collection($this->response->getData())
                ), Response::HTTP_OK
            );

        if ($this->response->getStatus() == Response::HTTP_NO_CONTENT)
            return $this->sendJson($this->response->getData(), $this->response->getStatus());

        if ($this->response->getStatus() == Response::HTTP_RESET_CONTENT)
            return $this->response->getData();
    }
}
