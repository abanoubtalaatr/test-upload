<?php

namespace App\Location\Responders;

use App\Infrastructure\Responders\Responder;
use App\Infrastructure\Helpers\Traits\RESTApi;
use App\Infrastructure\Helpers\Traits\ApiPaginator;
use App\Location\Domain\Resources\StateLiteResource;
use App\Location\Domain\Resources\StateResource;

class ListStatesResponder extends Responder
{
    use RESTApi, ApiPaginator;
    public function respond()
    {
        if(!auth()->guard('admin')->check() && $this->response->getStatus() == 200)
            return $this->sendJson(
                StateLiteResource::collection($this->response->getData())
            );
        if(auth()->guard('admin')->check() && $this->response->getStatus() == 200 )
            return $this->sendJson(
                StateLiteResource::collection($this->response->getData())
            );
        if($this->response->getStatus() == 201)
            return $this->sendJson(
                $this->getPaginatedResponse(
                    $this->response->getData(), 
                    StateResource::collection($this->response->getData())
                )
            );
    }
}