<?php

namespace App\Admin\Domain\Services\Admin;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Admin\Domain\Models\Admin;
use App\Admin\Domain\Filters\AdminFilter;
use App\Admin\Domain\Exports\AdminsExport;
use Excel;
use Symfony\Component\HttpFoundation\Response;

class ExportAdminsToExcelService extends Service
{
    protected $admin, $filter;

    public function __construct(Admin $admin, AdminFilter $filter)
    {
        $this->admin = $admin;
        $this->filter = $filter;
    }

    public function handle($data = [])
    {
        $store_id = null;
        if(auth()->guard('store')->check() || auth()->guard('center')->check())
            $store_id = auth()->user()->store_id;
        $this->admin = $this->admin
         ->when($store_id, function($collection) use ($store_id){
            return $collection->whereNotNull('store_id')->where('store_id', $store_id);
        }, function ($collection) {
            return $collection->whereNull('store_id');
        });

        return new GenericPayload(
        	Excel::download(new AdminsExport($this->admin, $this->filter), 'admins.xlsx'), Response::HTTP_RESET_CONTENT
        );
    }
}


