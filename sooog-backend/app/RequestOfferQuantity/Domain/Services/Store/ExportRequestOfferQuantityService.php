<?php

namespace App\RequestOfferQuantity\Domain\Services\Store;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\RequestOfferQuantity\Domain\Exports\RequestOfferQuantityExport;
use Symfony\Component\HttpFoundation\Response;
use Excel;

class ExportRequestOfferQuantityService extends Service
{
    public function handle($data = []): GenericPayload
    {
        return new GenericPayload(
            Excel::download(new RequestOfferQuantityExport(), 'requests.xlsx'), Response::HTTP_RESET_CONTENT
        );
    }
}
