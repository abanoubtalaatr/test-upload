<?php

namespace App\Admin\Actions\Permission;
use App\Admin\Domain\Requests\RoleRequest;
use App\Admin\Domain\Services\Permission\ListRolesService;
use App\Admin\Responders\RoleResponder;

class ListRolesAction 
{
    public function __construct(RoleResponder $responder, ListRolesService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(RoleRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}