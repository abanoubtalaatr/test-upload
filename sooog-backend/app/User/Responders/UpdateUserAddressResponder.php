<?php

namespace App\User\Responders;

use App\Infrastructure\Responders\Responder;
use App\User\Domain\Resources\UserAddressResource;
use App\Infrastructure\Helpers\Traits\RESTApi;

class UpdateUserAddressResponder extends Responder
{
    use RESTApi;

    public function respond()
    {
        if($this->response->getStatus() != 200)
        	return $this->sendError($this->response->getData());
        return $this->sendJson(
        	new UserAddressResource($this->response->getData()), 
        	$this->response->getStatus()
        );

    }
}