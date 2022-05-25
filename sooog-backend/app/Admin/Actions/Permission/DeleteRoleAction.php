<?php

namespace App\Admin\Actions\Permission;
use App\Admin\Domain\Services\Permission\DeleteRoleService;
use App\Admin\Responders\RoleResponder;

class DeleteRoleAction 
{
    public function __construct(RoleResponder $responder, DeleteRoleService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(["role_id" => $id])
        )->respond();
    }
}