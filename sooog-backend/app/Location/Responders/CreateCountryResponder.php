<?php

namespace App\Location\Responders;

use App\Infrastructure\Responders\Responder;
use App\Infrastructure\Helpers\Traits\RESTApi;
use App\Location\Domain\Resources\CountryResource;

class CreateCountryResponder extends Responder
{
    use RESTApi;
    public function respond()
    {
        if($this->response->getStatus() != 200)
        	return $this->sendError($this->response->getData());
        return $this->sendJson(
        	new CountryResource($this->response->getData()), 
        	$this->response->getStatus()
        );
    }
}