<?php

namespace App\Admin\Responders;

use App\Infrastructure\Responders\Responder;
use App\Infrastructure\Helpers\Traits\RESTApi;

class LoginAdminResponder extends Responder
{
    use RESTApi;
    public function respond()
    {
        if($this->response->getStatus() != 200)
        	return $this->sendError($this->response->getData());
        $admin = $this->response->getData();
        return $this->sendJson($this->response->getData(), $this->response->getStatus());
    }
}