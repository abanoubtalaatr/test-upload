<?php

namespace App\PromoCode\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\PromoCode\Domain\Models\PromoCode;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UpdatePromoCodeService extends Service
{
    public function handle($data = []) 
    {
        try {
            $promo_code = PromoCode::findOrFail($data['promo_code_id']);
            if(auth()->guard('store')->check() && $promo_code->created_by != 'store'){
                return new GenericPayload( __('error.cannotUpdate'), 422);
            }
            // Begin Transaction
            DB::beginTransaction();
            if($data['type'] == 'free_delivery_charge' || $data['type'] == 'free_cash_charge')
                $data['value'] = 0.00;
            $promo_code->update($data);
            if(isset($data['stores']))
                $promo_code->stores()->sync($data['stores']);
        // Commit Transaction
            DB::commit();
            return new GenericPayload($promo_code, Response::HTTP_CREATED);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            // Rollback Transaction
            DB::rollback();
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            // Rollback Transaction
            DB::rollback();
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            // Rollback Transaction
            DB::rollback();
            throw new ModelNotFoundException;
        } catch (\Illuminate\Database\QueryException $ex) {
            // Rollback Transaction
            DB::rollback();
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        } catch (\PDOException $ex){
            // Rollback Transaction
            DB::rollback();
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
    }
}
