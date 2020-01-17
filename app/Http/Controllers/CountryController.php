<?php

namespace App\Http\Controllers;

use App\Models\Country;


class CountryController extends Controller
{

    public function get()
    {
        $request = request();
        if ($request) {
            return \Response::json([
                'success'    => true,
                'rootDomain' => \Request::root(),
                'message'    => Country::query()
                    ->whereNotNUll('code')
                    ->whereNotNUll('flag')
                    ->get(['code', 'flag']),
            ], 200);
        }

        return \Response::json([
            'success' => false,
        ], 400);
    }

}
