<?php

namespace App\Admin\Responders;

use App\Infrastructure\Responders\Responder;
use App\Admin\Domain\Resources\AdminResource;
use App\Infrastructure\Helpers\Traits\RESTApi;

class UpdateProfileResponder extends Responder
{
    use RESTApi;

    public function respond()
    {
        if($this->response->getStatus() != 200)
        	return $this->sendError($this->response->getData());
        $admin = $this->response->getData();
        return $this->sendJson(new AdminResource($admin), $this->response->getStatus());

    }
}