<?php

namespace App\Location\Responders;

use App\Infrastructure\Responders\Responder;
use App\Infrastructure\Helpers\Traits\RESTApi;
use App\Location\Domain\Resources\CityResource;

class CreateCityResponder extends Responder
{
    use RESTApi;
    public function respond()
    {
        if($this->response->getStatus() != 200)
        	return $this->sendError($this->response->getData());
        return $this->sendJson(
        	new CityResource($this->response->getData()), 
        	$this->response->getStatus()
        );
    }
}