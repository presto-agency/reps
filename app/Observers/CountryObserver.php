<?php

namespace App\Observers;

use App\Models\Country;

class CountryObserver
{

    public function creating(Country $country)
    {

    }

    /**
     * Handle the country "created" event.
     *
     * @param \App\Models\Country $country
     * @return void
     */
    public function created(Country $country)
    {

    }

    public function updating(Country $country)
    {

    }

    /**
     * Handle the country "updated" event.
     *
     * @param \App\Models\Country $country
     * @return void
     */
    public function updated(Country $country)
    {
        //
    }

    /**
     * Handle the country "deleted" event.
     *
     * @param \App\Models\Country $country
     * @return void
     */
    public function deleted(Country $country)
    {
        //
    }

    /**
     * Handle the country "restored" event.
     *
     * @param \App\Models\Country $country
     * @return void
     */
    public function restored(Country $country)
    {
        //
    }

    /**
     * Handle the country "force deleted" event.
     *
     * @param \App\Models\Country $country
     * @return void
     */
    public function forceDeleted(Country $country)
    {
        //
    }

}
