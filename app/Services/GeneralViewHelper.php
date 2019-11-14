<?php
/**
 * Created by PhpStorm.
 * User: MAX
 * Date: 14.11.2019
 * Time: 10:17
 */

namespace App\Services;


use App\Models\Country;

class GeneralViewHelper
{
    protected static $instance;

    protected $countries;


    public function __construct()
    {
        if (!self::$instance) {
            self::$instance = $this;
        }

    }


    /**
     * @return Country[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCountries()
    {
        if (!self::$instance->countries) {
            $countries = Country::all();

            foreach ($countries as $country) {
                self::$instance->countries[$country->id] = $country;
            }
        }
        return self::$instance->countries;
    }


}