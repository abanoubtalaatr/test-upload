<?php

namespace App\Location\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Location\Domain\Models\State;
use Symfony\Component\HttpFoundation\Response;

class CreateStateService extends Service
{
    public function handle($data = []) 
    {
        $state = State::create($data);
        return new GenericPayload($state, Response::HTTP_CREATED);

    }
}