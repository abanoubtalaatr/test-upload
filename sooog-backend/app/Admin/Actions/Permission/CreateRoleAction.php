<?php

namespace App\Admin\Actions\Permission;
use App\Admin\Domain\Requests\RoleRequest;
use App\Admin\Domain\Services\Permission\CreateRoleService;
use App\Admin\Responders\RoleResponder;

class CreateRoleAction 
{
    public function __construct(RoleResponder $responder, CreateRoleService $service) 
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