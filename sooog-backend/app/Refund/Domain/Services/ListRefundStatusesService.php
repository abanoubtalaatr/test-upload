<?php

namespace App\Refund\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Order\Domain\Models\Status;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ListRefundStatusesService extends Service
{
    public function handle($data = []) 
    {
        $statuses = Status::whereType('refund')->get();
        return new GenericPayload($statuses, Response::HTTP_OK);
    }
}