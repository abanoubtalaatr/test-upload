<?php
namespace App\Ad\Domain\Filters;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Infrastructure\Domain\Filters\QueryFilter;

class AdFilter extends QueryFilter
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

    // public function orderBy($orderBy)
    // {
    //     $this->builder->when($orderBy != 'name', function($collection) use ($orderBy){
    //         return $collection->orderBy($orderBy, request()->orderType ?? 'DESC');
    //     })
    //     ->when($orderBy == 'name', function($collection) {
    //         return $collection->whereHas('translations', function($q) {
    //             $q->orderBy('name', request()->orderType ?? 'DESC');
    //         });
    //     });
    // }

    public function publicSearch($search)
    {
        $this->builder->whereHas('translations', function($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        });
    }
}
