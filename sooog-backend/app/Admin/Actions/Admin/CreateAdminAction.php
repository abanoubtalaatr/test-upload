<?php

namespace App\Admin\Actions\Admin;
use App\Admin\Domain\Requests\AdminRequest;
use App\Admin\Domain\Services\Admin\CreateAdminService;
use App\Admin\Responders\AdminResponder;

class CreateAdminAction 
{
    public function __construct(AdminResponder $responder, CreateAdminService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(AdminRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}