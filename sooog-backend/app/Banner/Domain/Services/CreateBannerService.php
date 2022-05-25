<?php

namespace App\Banner\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Ad\Domain\Models\Ad;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CreateBannerService extends Service
{
    public function handle($data = []) 
    {
        try {
            // Begin Transaction
            DB::beginTransaction();
            $data['is_active'] = isset($data['is_active']) ? isset($data['is_active']) : 1;
	        $ad = Ad::create($data);
	        // Commit Transaction
	        DB::commit();
	        return new GenericPayload($ad, Response::HTTP_CREATED);
	        
	    }catch (\Illuminate\Database\QueryException $ex) {
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
        } catch (\Exception $ex) {
        	// Rollback Transaction
            DB::rollback();
            return new GenericPayload(
                 __('error.someThingWrong'), 422
            );
        }

    }
}
