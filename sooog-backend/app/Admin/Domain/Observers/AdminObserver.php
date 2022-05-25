<?php

namespace App\Admin\Domain\Observers;

use App\Admin\Domain\Models\Admin;
use App\Store\Domain\Models\StoreAdmin;
use Illuminate\Support\Arr;

class AdminObserver
{
    /**
     * Handle the StoreAdmin "created" event.
     *
     * @param  \App\Models\StoreAdmin $storeAdmin
     * @return void
     */
    public function created(Admin $storeAdmin)
    {

    }

    /**
     * Handle the StoreAdmin "updated" event.
     *
     * @param  \App\Models\StoreAdmin $storeAdmin
     * @return void
     */
    public function updated(Admin $storeAdmin)
    {
        if ($storeAdmin->user) {
            $data = Arr::only($storeAdmin->toArray(), ['name', 'email', 'password', 'phone', 'avatar', 'is_active']);
            $storeAdmin->user()->update($data);
        }
    }

    /**
     * Handle the StoreAdmin "deleted" event.
     *
     * @param  \App\Models\StoreAdmin $storeAdmin
     * @return void
     */
//    public function deleted(StoreAdmin $storeAdmin)
//    {
//        //
//    }

    /**
     * Handle the StoreAdmin "restored" event.
     *
     * @param  \App\Models\StoreAdmin $storeAdmin
     * @return void
     */
//    public function restored(StoreAdmin $storeAdmin)
//    {
//        //
//    }

    /**
     * Handle the StoreAdmin "force deleted" event.
     *
     * @param  \App\Models\StoreAdmin $storeAdmin
     * @return void
     */
//    public function forceDeleted(StoreAdmin $storeAdmin)
//    {
//        //
//    }
}
