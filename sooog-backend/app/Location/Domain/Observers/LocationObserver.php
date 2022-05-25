<?php

namespace App\Location\Domain\Observers;

use App\Location\Domain\Models\Country;

class LocationObserver
{
    /**
     * Handle the location "created" event.
     *
     * @param  \App\Location\Domain\Models\Country  $location
     * @return void
     */
    public function created(Country $location)
    {
        //
    }

    /**
     * Handle the location "updated" event.
     *
     * @param  \App\Location\Domain\Models\Country  $location
     * @return void
     */
    public function updated(Country $location)
    {
        //
    }

    /**
     * Handle the location "deleted" event.
     *
     * @param  \App\Location\Domain\Models\Country  $location
     * @return void
     */
    public function deleted(Country $location)
    {
        //
    }

    /**
     * Handle the location "restored" event.
     *
     * @param  \App\Location\Domain\Models\Country  $location
     * @return void
     */
    public function restored(Country $location)
    {
        //
    }

    /**
     * Handle the location "force deleted" event.
     *
     * @param  \App\Location\Domain\Models\Country  $location
     * @return void
     */
    public function forceDeleted(Country $location)
    {
        //
    }
}
