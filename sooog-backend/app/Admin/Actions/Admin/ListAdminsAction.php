<?php

namespace App\Admin\Actions\Admin;
use App\Admin\Domain\Requests\AdminRequest;
use App\Admin\Domain\Services\Admin\ListAdminsService;
use App\Admin\Responders\AdminResponder;

class ListAdminsAction 
{
    public function __construct(AdminResponder $responder, ListAdminsService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(AdminRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request)
        )->respond();
    }
}