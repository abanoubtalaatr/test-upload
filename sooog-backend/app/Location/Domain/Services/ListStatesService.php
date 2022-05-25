<?php

namespace App\Location\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Location\Domain\Models\State;
use App\Location\Domain\Filters\StateFilter;
use Symfony\Component\HttpFoundation\Response;

class ListStatesService extends Service
{
    protected $state, $filter;

    public function __construct(State $state, StateFilter $filter)
    {
        $this->state = $state;
        $this->filter = $filter;
    }

    public function handle($data = []) 
    {
        $order = isset($data['orderBy']) ? $data['orderBy'] : 'id';
        $order_type = isset($data['orderType']) ? $data['orderType'] : 'DESC';
        $limit = isset($data['per_page']) ? $data['per_page'] : config('app.pagination_limit');
        $active = isset($data['active']) ? $data['active'] : 1;
        $cities = isset($data['cities']) ? $data['cities'] : 0;
        if(isset($data['active']) && $data['active'] == 'true')
            $active = 1;
        if(isset($data['active']) && $data['active'] == 'false')
            $active = 0;

        if( isset($data['is_paginated']) && $data['is_paginated'] == 1 ):
            $states = $this->state->filter($this->filter)
            ->when(isset($data['active']), function($collection) use ($active){
                return $collection->active($active);
            })
            ->when($order == 'name', function($collection) use ($order_type){
                return $collection->join('state_translations', function ($join) {
                    $join->on('states.id', '=', 'state_translations.state_id')
                        ->where('state_translations.locale', '=', app()->getLocale());
                }) 
                ->groupBy('states.id')
                ->orderBy('state_translations.name', $order_type)
                ->select('states.*', 'state_translations.id as state_translation_id');
            })
            ->when($order != 'name', function($collection) use ($order, $order_type){
                return $collection->orderBy($order, $order_type);
            })
            ->whereHas('country', function($q) {
                        $q->where('is_active', 1);
                    })
            ->paginate($limit);
            return new GenericPayload($states, Response::HTTP_ACCEPTED);
        else:
            // if(auth('admin')->check())
            //     $states = $this->state->filter($this->filter)->get();
            // else
                $states = $this->state->filter($this->filter)->active(1)
                ->whereHas('country', function($q) {
                        $q->where('is_active', 1);
                    })
                ->when(!auth('admin')->check()||$cities==1||request('all')!=1, function($collection){
                    return $collection->whereHas('cities', function($q) {
                        $q->where('is_active', 1);
                    });
                })
                ->get();

            return new GenericPayload($states, Response::HTTP_OK);
        endif;
    }
}
