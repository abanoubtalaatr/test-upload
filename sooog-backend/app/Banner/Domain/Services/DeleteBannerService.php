<?php

namespace App\Ad\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Ad\Domain\Models\Ad;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class DeleteAdService extends Service
{
    public function handle($data = []) 
    {
        try {
            $ad = Ad::findOrFail($data['ad_id']);
            $ad->delete();
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
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
        return new GenericPayload(['message' => __('success.deletedSuccessfuly')], Response::HTTP_NO_CONTENT);

    }
}