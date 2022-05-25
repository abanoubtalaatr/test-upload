<?php

namespace App\PromoCode\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\PromoCode\Domain\Models\PromoCode;
use App\PromoCode\Domain\Filters\PromoCodeFilter;
use App\PromoCode\Domain\Exports\PromoCodesExport;
use Excel;
use Symfony\Component\HttpFoundation\Response;

class ExportPromoCodesToExcelService extends Service
{
    protected $promo_code, $filter;

    public function __construct(PromoCode $promo_code, PromoCodeFilter $filter)
    {
        $this->promo_code = $promo_code;
        $this->filter = $filter;
    }

    public function handle($data = []) 
    {
        // $promo_codes = $this->promo_code->filter($this->filter)->get();
        // return new GenericPayload(
        // 	Excel::download(new PromoCodesExport($promo_codes), 'promo_codes.xlsx', Response::HTTP_RESET_CONTENT)
        // );
        $store_id = auth()->user()->store_id;
        return new GenericPayload(
            Excel::download(new PromoCodesExport(
                $this->promo_code->when($store_id, function($collection) use ($store_id){
                    return $collection->whereRelation('stores', 'stores.id', $store_id);
                }), 
                $this->filter), 
            'promo_codes.xlsx'),
            Response::HTTP_RESET_CONTENT
        );


    }
}


    