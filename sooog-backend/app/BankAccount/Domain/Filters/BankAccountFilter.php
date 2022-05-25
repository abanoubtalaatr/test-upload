<?php
namespace App\BankAccount\Domain\Filters;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Infrastructure\Domain\Filters\QueryFilter;
class BankAccountFilter extends QueryFilter
{

    public function isActive($is_active)
    {
        $this->builder->where('is_active', $is_active);
    }

    public function name($name)
    {
        $this->builder->whereHas('translations', function($q) use ($name) {
            $q->where('name', 'like', '%' . $name . '%');
        });
    }

    public function publicSearch($search)
    {
        $this->builder->whereHas('translations', function($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        })
        ->orWhere('account_number', 'like', '%'.$search.'%')
        ->orWhere('iban_number', 'like', '%'.$search.'%')
        ->orWhere('is_active', $search);
    }

    public function orderBy($orderBy)
    {
        $this->builder->when($orderBy != 'name', function($collection) use ($orderBy){
            return $collection->orderBy($orderBy, request()->orderType ?? 'DESC');
        })
        ->when($orderBy == 'name', function($collection) {
            return $collection->join('bank_account_translations as trans', 'bank_accounts.id', '=', 'trans.bank_account_id')
            ->orderBy('trans.name', request()->orderType ?? 'DESC')
            ->where('trans.locale', '=', app()->getLocale());
        });
    }

}
