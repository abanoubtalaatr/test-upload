<?php
namespace App\PromoCode\Domain\Filters;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Infrastructure\Domain\Filters\QueryFilter;

class PromoCodeFilter extends QueryFilter
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

    public function orderBy($orderBy)
    {
        $this->builder->when($orderBy != 'name', function($collection) use ($orderBy){
            return $collection->orderBy($orderBy, request()->orderType ?? 'DESC');
        })
        ->when($orderBy == 'name', function($collection) {
            return $collection->orderBy('promo_code_translations.name', request()->orderType ?? 'DESC')
            ->where('promo_code_translations.locale', app()->getLocale());
        });
    }

    public function publicSearch($search)
    {
        $this->builder->whereHas('translations', function($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        })
        ->orWhere('code', $search)
        ->orWhere('type', $search);
    }

    public function type($type)
    {
        $this->builder->where('type', $type);
    }

    public function date($date)
    {

        //$this->builder->where('created_at', 'like', '%'. $date.'%');
        $date = Carbon::parse($date)->toDateTimeString();
        $this->builder->where([
            ['start_date', '<=', $date],
            ['end_date', '>=', $date]
        ]);
        //->orWhereDate('end_date', '<=', $date);
    }
}
