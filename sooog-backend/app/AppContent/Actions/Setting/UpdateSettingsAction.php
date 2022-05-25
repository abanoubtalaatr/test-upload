<?php

namespace App\AppContent\Actions\Setting;
use App\AppContent\Domain\Requests\SettingRequest;
use App\AppContent\Domain\Services\Setting\UpdateSettingsService;
use App\AppContent\Responders\SettingResponder;

class UpdateSettingsAction 
{
    public function __construct(SettingResponder $responder, UpdateSettingsService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(SettingRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}