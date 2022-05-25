<?php

namespace App\BankAccount\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\BankAccount\Domain\Models\BankAccount;
use App\BankAccount\Domain\Filters\BankAccountFilter;
use Symfony\Component\HttpFoundation\Response;

class ListBankAccountsService extends Service
{
    protected $account, $filter;

    public function __construct(BankAccount $account, BankAccountFilter $filter)
    {
        $this->account = $account;
        $this->filter = $filter;
    }

    public function handle($data = [])
    {
        $order = isset($data['orderBy']) ? $data['orderBy'] : 'id';
        $order_type = isset($data['orderType']) ? $data['orderType'] : 'DESC';
        $limit = isset($data['per_page']) ? $data['per_page'] : config('app.pagination_limit');
        $active = isset($data['active']) ? $data['active'] : 1;
        if( isset($data['is_paginated']) && $data['is_paginated'] == 'true')
            $data['is_paginated'] = 1;

        if( isset($data['is_paginated']) && $data['is_paginated'] == 1):
            $accounts = $this->account
            ->filter($this->filter)
            ->when(isset($data['active']), function($collection) use ($active){
                return $collection->active($active);
            })
            ->paginate($limit);
            return new GenericPayload($accounts, Response::HTTP_ACCEPTED);
        else:
            $accounts = $this->account->active(1)->orderBy('id', 'desc')->get();
            return new GenericPayload($accounts, Response::HTTP_OK);
        endif;

    }
}
