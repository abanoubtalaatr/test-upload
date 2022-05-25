<?php

namespace App\Banner\Domain\Services;

use App\Banner\Domain\Models\Banner;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UpdateBannerService extends Service
{
    public function handle($data = []) 
    {
        try {
            // Begin Transaction
            DB::beginTransaction();
            $ad = Banner::findOrFail($data['banner_id']);
            $updateData=Arr::except($data,'banner_id');
            $ad->update($updateData);
            // Commit Transaction
            DB::commit();
            return new GenericPayload($ad, Response::HTTP_CREATED);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            // Rollback Transaction
            DB::rollback();
            throw new ModelNotFoundException;
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
