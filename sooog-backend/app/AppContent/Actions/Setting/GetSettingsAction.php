<?php

namespace App\AppContent\Actions\Setting;

use App\AppContent\Domain\Services\Setting\GetSettingsService;
use App\AppContent\Responders\SettingResponder;

class GetSettingsAction 
{
    public function __construct(SettingResponder $responder, GetSettingsService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke() 
    {
        return $this->responder->withResponse(
            $this->service->handle()
        )->respond();
    }
}