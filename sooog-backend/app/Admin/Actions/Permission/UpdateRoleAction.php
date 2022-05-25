<?php

namespace App\Admin\Actions\Permission;
use App\Admin\Domain\Requests\RoleRequest;
use App\Admin\Domain\Services\Permission\UpdateRoleService;
use App\Admin\Responders\RoleResponder;

class UpdateRoleAction 
{
    public function __construct(RoleResponder $responder, UpdateRoleService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(RoleRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(array_merge($request->validated(), ["role_id" => $id]))
        )->respond();
    }
}