<?php

namespace App\Store\Domain\Services\Auth;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Store\Domain\Models\StoreTemp;

class UpdateBankDataService extends Service
{
    public function handle($data = [])
    {
        try {
            $admin = auth()->user();
//            $admin->store->update($data);
            if ($storeTemp = StoreTemp::where('store_id', $admin->store->id)->first()) {
                $storeTemp->update($data);
            } else {
                $storeData = $admin->store->toArray();
                $storeData['store_id'] = $admin->store->id;
                $storeData['ar'] = $admin->store->translate('ar')->toArray();
                $storeData['en'] = $admin->store->translate('en')->toArray();
                $storeTemp = StoreTemp::create($storeData);
                $storeTemp->update($data);
            }

        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
        return new GenericPayload($admin);
    }
}
