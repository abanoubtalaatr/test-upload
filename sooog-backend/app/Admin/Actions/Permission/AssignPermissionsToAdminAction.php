<?php

namespace App\Admin\Actions\API;
use App\Admin\Domain\Requests\AssignPermissionsToAdminFormRequest;
use App\Admin\Domain\Services\API\AssignPermissionsToAdminService;
use App\Admin\Responders\API\AssignPermissionsToAdminResponder;

class AssignPermissionsToAdminAction 
{
    public function __construct(AssignPermissionsToAdminResponder $responder, AssignPermissionsToAdminService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(AssignPermissionsToAdminFormRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(array_merge($request->validated(), ["admin_id" => $id]))
        )->respond();
    }
}