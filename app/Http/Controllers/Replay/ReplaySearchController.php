<?php

namespace App\Http\Controllers\Replay;

use App\Http\Controllers\Controller;
use App\Models\Replay;
use Illuminate\Http\Request;

class ReplaySearchController extends Controller
{
    public function index()
    {
//        dd($this->searchResult());
        return view('replay.search')->with(
            [
                'replay' => $this->searchResult(),
            ]
        );
    }

    private function searchResult()
    {
        $relations = [
            'users:id,name,avatar',
            'maps:id,name',
            'firstCountries:id,flag,name',
            'secondCountries:id,flag,name',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',
            'comments',
        ];
        $query = Replay::with($relations)
            ->where('approved', 1)
            ->where('id', '>', 0)//        ->get()
        ;

        if (request()->has('text') && request()->filled('text')) {
            $query->where(function ($q) {
                $q->orWhere('title', 'like', '%' . request('text') . '%')
                    ->orWhere('content', 'like', '%' . request('text') . '%');
            });
        }
//        dd($query->get());
//            ->where('title', 'like', '%' . request('text') . '%')
//            ->orWhere('content', 'like', '%' . request('text', '') . '%')
//            ->where('first_country_id', 'like', '%' . request('first_country_id', '') . '%')
//            ->where('second_country_id', 'like', '%' . request('second_country_id', '') . '%')
//            ->where('first_race', 'like', '%' . request('first_race', '') . '%')
//            ->where('second_race', 'like', '%' . request('second_race', '') . '%')
//            ->where('map_id', 'like', '%' . request('map_id', '') . '%')
//            ->where('type_id', 'like', '%' . request('type_id', '') . '%')
//            ->where('user_replay', 'like', '%' . request('user_replay', '') . '%')
//            ->get();
        return $query;
    }
}
