<?php

namespace App\Location\Responders;

use App\Infrastructure\Responders\Responder;
use App\Infrastructure\Helpers\Traits\RESTApi;
use App\Location\Domain\Resources\StateResource;

class CreateStateResponder extends Responder
{
    use RESTApi;
    public function respond()
    {
        if($this->response->getStatus() != 200)
        	return $this->sendError($this->response->getData());
        return $this->sendJson(
        	new StateResource($this->response->getData()), 
        	$this->response->getStatus()
        );
    }
}