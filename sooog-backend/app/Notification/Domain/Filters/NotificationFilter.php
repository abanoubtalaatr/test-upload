<?php
namespace App\Notification\Domain\Filters;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Infrastructure\Domain\Filters\QueryFilter;

class NotificationFilter extends QueryFilter
{

    public function status($is_active)
    {
        $this->builder->where('is_active', $is_active);
    }

    public function name($name)
    {
        $this->builder->whereHas('translations', function($q) use ($name) {
                $q->where('display_name', 'like', '%' . $name . '%');
            });
    }

    public function publicSearch($search)
    {
//        $this->builder->where('data->ar->title', 'like', '%' . $search . '%')
//        ->orWhere('data->ar->body', 'like', '%' . $search . '%')
//        ->orWhere('data->en->title', 'like', '%' . $search . '%')
//        ->orWhere('data->en->body', 'like', '%' . $search . '%')
//        ->orWhere('data->en->body', 'like', '%' . $search . '%')
//        ;
        $this->builder->where('data','like','%'.$search.'%');
        
    }

    
}
