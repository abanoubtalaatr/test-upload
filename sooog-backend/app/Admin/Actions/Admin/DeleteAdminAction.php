<?php

namespace App\Admin\Actions\Admin;
use App\Admin\Domain\Services\Admin\DeleteAdminService;
use App\Admin\Responders\AdminResponder;

class DeleteAdminAction 
{
    public function __construct(AdminResponder $responder, DeleteAdminService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(["admin_id" => $id])
        )->respond();
    }
}