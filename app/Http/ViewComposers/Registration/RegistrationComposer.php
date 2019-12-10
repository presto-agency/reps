<?php
/**
 * Created by PhpStorm.
 * User: MAX
 * Date: 23.10.2019
 * Time: 10:33
 */

namespace App\Http\ViewComposers\Registration;

use App\Models\Country;
use App\Models\Race;
use Illuminate\View\View;

class RegistrationComposer
{
    private static $ttl = 300;

    public function compose(View $view)
    {
        return $view->with([
            'race' => self::getCacheRac('race'),
            'countries' => self::getCacheCountry('countries')
        ]);
    }

    public static function getCacheRac($cache_name)
    {
        if (\Cache::has($cache_name) && !empty(\Cache::get($cache_name))) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return Race::all();
            });
        }
        return $data_cache;
    }

    public static function getCacheCountry($cache_name)
    {
        if (\Cache::has($cache_name) && !empty(\Cache::get($cache_name))) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return Country::all();
            });
        }
        return $data_cache;
    }
}

