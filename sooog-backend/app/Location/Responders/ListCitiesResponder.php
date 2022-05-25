<?php

namespace App\Location\Responders;

use App\Infrastructure\Responders\Responder;
use App\Infrastructure\Helpers\Traits\RESTApi;
use App\Infrastructure\Helpers\Traits\ApiPaginator;
use App\Location\Domain\Resources\CityLiteResource;
use App\Location\Domain\Resources\CityResource;

class ListCitiesResponder extends Responder
{
    use RESTApi, ApiPaginator;
    public function respond()
    {
        if(!auth()->guard('admin')->check() && $this->response->getStatus() == 200)
            return $this->sendJson(
                CityLiteResource::collection($this->response->getData())
            );
        if(auth()->guard('admin')->check() && $this->response->getStatus() == 200 )
            return $this->sendJson(
                CityLiteResource::collection($this->response->getData())
            );
        return $this->sendJson(
            $this->getPaginatedResponse(
                $this->response->getData(), 
                CityResource::collection($this->response->getData())
            )
        );
    }
}