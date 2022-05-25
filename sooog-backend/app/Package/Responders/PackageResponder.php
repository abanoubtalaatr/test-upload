<?php

namespace App\Package\Responders;

use App\Package\Domain\Resources\PackageLiteResource;
use App\Infrastructure\Responders\Responder;
use App\Infrastructure\Helpers\Traits\RESTApi;
use App\Infrastructure\Helpers\Traits\ApiPaginator;
use App\Package\Domain\Resources\PackageResource;
use Symfony\Component\HttpFoundation\Response;

class PackageResponder extends Responder
{
    use RESTApi, ApiPaginator;

    public function respond()
    {
        if(!in_array($this->response->getStatus(), array_values(config('statuses.SUCCESS'))))
            return $this->sendError($this->response->getData());

        if($this->response->getStatus() == Response::HTTP_CREATED)
            return $this->sendJson(
                new PackageResource($this->response->getData()),
                Response::HTTP_OK
            );

        if($this->response->getStatus() == Response::HTTP_OK)
            return $this->sendJson(
                PackageLiteResource::collection($this->response->getData()),
                $this->response->getStatus()
            );
        
        if($this->response->getStatus() == Response::HTTP_ACCEPTED)
            return $this->sendJson(
                $this->getPaginatedResponse(
                    $this->response->getData(),
                    PackageLiteResource::collection($this->response->getData())
                ), Response::HTTP_OK
            );

        if($this->response->getStatus() == Response::HTTP_NO_CONTENT)
            return $this->sendJson($this->response->getData(), $this->response->getStatus());

        if($this->response->getStatus() == Response::HTTP_RESET_CONTENT)
            return $this->response->getData();

    }
}
