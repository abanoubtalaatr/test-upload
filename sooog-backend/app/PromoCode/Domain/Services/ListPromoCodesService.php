<?php

namespace App\PromoCode\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\PromoCode\Domain\Models\PromoCode;
use App\PromoCode\Domain\Filters\PromoCodeFilter;
use Symfony\Component\HttpFoundation\Response;

class ListPromoCodesService extends Service
{
    protected $promo_code, $filter;

    public function __construct(PromoCode $promo_code, PromoCodeFilter $filter)
    {
        $this->promo_code = $promo_code;
        $this->filter = $filter;
    }

    public function handle($data = []) 
    {
        $order = isset($data['orderBy']) ? $data['orderBy'] : 'id';
        $order_type = isset($data['orderType']) ? $data['orderType'] : 'DESC';
        $limit = isset($data['per_page']) ? $data['per_page'] : config('app.pagination_limit');
        $active = isset($data['active']) ? $data['active'] : 1;
        $store_id = auth()->user()->store_id;

        
        $promo_codes = $this->promo_code
            ->filter($this->filter)
            ->when(isset($data['active']), function($collection) use ($active){
                return $collection->active($active);
            })
            ->when($store_id, function($collection) use ($store_id){
                return $collection->whereRelation('stores', 'stores.id', $store_id);
            })
            ->when($order == 'name', function($collection) use ($order_type){
                return $collection->join('promo_code_translations', function ($join) {
                    $join->on('promo_codes.id', '=', 'promo_code_translations.promo_code_id')
                        ->where('promo_code_translations.locale', '=', app()->getLocale());
                }) 
                ->groupBy('promo_codes.id')
                ->orderBy('promo_code_translations.name', $order_type)
                ->select('promo_codes.*', 'promo_code_translations.id as promo_code_translation_id');
            })
            ->when($order != 'name', function($collection) use ($order, $order_type){
                return $collection->orderBy($order, $order_type);
            })
            ->paginate($limit);
        return new GenericPayload($promo_codes, Response::HTTP_ACCEPTED);
    }
}