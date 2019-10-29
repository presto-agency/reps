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
    public function compose(View $view)
    {
        $race = Race::all();
        $countries = Country::all();
        return $view->with(['race' => $race, 'countries' => $countries]);
    }
}
