<?php

namespace App\Refund\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Refund\Domain\Models\Refund;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use DB;
use App\Refund\Domain\Filters\RefundFilter;
use Symfony\Component\HttpFoundation\Response;

class ListRefundsService extends Service
{
    protected $refund, $filter;

    public function __construct(Refund $refund, RefundFilter $filter)
    {
        $this->refund = $refund;
        $this->filter = $filter;
    }

    public function handle($data = []) 
    {
        try {
            $order = isset($data['orderBy']) ? $data['orderBy'] : 'id';
            $order_type = isset($data['orderType']) ? $data['orderType'] : 'DESC';
            $store_id = null;
            if(auth()->guard('store')->check())
                $store_id = auth()->user()->store_id;
            $limit = isset($data['per_page']) ? $data['per_page'] : config('app.pagination_limit');
            $refunds = $this->refund->filter($this->filter)
            ->when($store_id, function($collection) use ($store_id){
                return $collection->ofStore($store_id);
            })
            ->with('refundItems')->orderBy($order, $order_type)->paginate($limit);
            return new GenericPayload($refunds, Response::HTTP_ACCEPTED);
        } catch (\Illuminate\Database\QueryException $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        } catch (\PDOException $ex){
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        } 
        catch (\Exception $ex) {
            return new GenericPayload(
                $ex->getMessage(), 422
            );
        }
    }

}