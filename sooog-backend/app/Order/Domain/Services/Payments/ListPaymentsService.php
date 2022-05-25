<?php

namespace App\Order\Domain\Services\Payments;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Order\Domain\Models\Payment;
use App\Order\Domain\Filters\PaymentFilter;
use Symfony\Component\HttpFoundation\Response;

class ListPaymentsService extends Service
{
    protected $payment, $filter;

    public function __construct(Payment $payment, PaymentFilter $filter)
    {
        $this->payment = $payment;
        $this->filter = $filter;
    }

    public function handle($data = []) 
    {
        try {

            // $store_id = null;
            // if(auth()->guard('store')->check() || auth()->guard('center')->check())
            //     $store_id = auth()->user()->store_id;

            $limit = isset($data['per_page']) ? $data['per_page'] : config('app.pagination_limit');

            $payments = $this->payment->filter($this->filter)->orderBy('id', 'desc')->paginate($limit);

            return new GenericPayload($payments, Response::HTTP_ACCEPTED);
        } catch (\Illuminate\Database\QueryException $ex) {
            return new GenericPayload(
               $ex->getMessage(), 422
            );
        } catch (\PDOException $ex){
            return new GenericPayload(
               $ex->getMessage(), 422
            );
        } 
        catch (\Exception $ex) {
            return new GenericPayload(
                $ex->getMessage(), 422
            );
        }
    }

}