<?php

namespace App\Observers;

use App\Models\Country;
use App\Services\ImageService\ResizeImage;

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
        $filePth = $country->getAttribute('flag');

        if (!empty($filePth)) {
            $fileName = $this->getFileName($filePth);
            dd($fileName,$filePth);
            new ResizeImage;
            ResizeImage::resizeFlagImage25x20($fileName,$filePth);
        }
    }

    public function updating(Country $country)
    {
        $filePth = $country->getAttribute('flag');

        if (!empty($filePth)) {
            $fileName = $this->getFileName($filePth);
            new ResizeImage;
            ResizeImage::resizeFlagImage25x20($fileName,$filePth);
        }
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

    /**
     * @param $filePath
     * @return mixed
     */
    public function getFileName($filePath)
    {
        $getImgName1 = explode('/', $filePath);
        $getImgName2 = explode('.', end($getImgName1));
        return $fileName = reset($getImgName2);
    }

}
