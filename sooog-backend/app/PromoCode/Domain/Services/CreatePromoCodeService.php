<?php

namespace App\PromoCode\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\PromoCode\Domain\Models\PromoCode;
use Illuminate\Support\Facades\DB;
use App\Notification\Domain\Notifications\GeneralNotification;
use Symfony\Component\HttpFoundation\Response;

class CreatePromoCodeService extends Service
{
    public function handle($data = []) 
    {
        try {
            
            $data['is_active'] = isset($data['is_active']) ? isset($data['is_active']) : 1;
            $data['store_id'] = auth()->user()->store_id;
            if(auth()->guard('store')->check() || auth()->guard('center')->check()){
                $data['stores'] = array(auth()->user()->store_id);
                $data['created_by'] = 'store';
            }

            if(!isset($data['stores']))
                return new GenericPayload(__('error.requiredStore'), 422);

            // Begin Transaction
            DB::beginTransaction();
	        $promo_code = PromoCode::create($data);
	        if(isset($data['stores']))
	        	$promo_code->stores()->sync($data['stores'], false);
	        // Commit Transaction
	        DB::commit();
            $notif_data = array(
                'en' => ['title' => 'new Promo code: '.$promo_code->code, 'body' => "new Promo code ({$promo_code->code}) has been added starting from {$promo_code->start_date} to {$promo_code->end_date}"],
                'ar' => ['title' => 'كود خصم جديد: '.$promo_code->code, 'body' => "تم إضافة كود خصم جديد وهو : {$promo_code->code} بدءا من  {$promo_code->start_date} ختى {$promo_code->end_date}"],
            );
            send_fcm_notification(
                null, 
                [
                    "title" => __('general.newCoupon'). $promo_code->code,
                    "body"  => __('general.newAddedCoupon'). $promo_code->code . __('general.starting_from'). $promo_code->start_date. __('general.to'). $promo_code->end_date, 
                    "type"  => 'coupon'
                ]
            );
            $users = \App\User\Domain\Models\User::whereIsActive(1)->get();
            if(count($users) > 0){
                foreach ($users as $user) {
                    $user->notify(new GeneralNotification(
                        $notif_data
                    ));
                }
            }
	        return new GenericPayload($promo_code, Response::HTTP_CREATED);
	        
	    }catch (\Illuminate\Database\QueryException $ex) {
            // Rollback Transaction
            DB::rollback();
            return new GenericPayload(
                $ex->getMessage(), 422
            );
        } catch (\PDOException $ex){
            // Rollback Transaction
            DB::rollback();
            return new GenericPayload(
                $ex->getMessage(), 422
            );
        } catch (\Exception $ex) {
        	// Rollback Transaction
            DB::rollback();
            return new GenericPayload(
                $ex->getMessage(), 422
            );
        }

    }
}