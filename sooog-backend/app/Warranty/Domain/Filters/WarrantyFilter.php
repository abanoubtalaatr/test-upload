<?php
namespace App\Warranty\Domain\Filters;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Infrastructure\Domain\Filters\QueryFilter;

class WarrantyFilter extends QueryFilter
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
        ->orWhereHas('store', function($q) use ($search){
            $q->whereRelation('translations', 'name', 'like', '%' . $search . '%');
        })
        ->orWhere('price', 'like', '%'. $search . '%');
    }

    public function storeId($store_id){
        $this->builder->where('store_id', $store_id);
    }

    
}