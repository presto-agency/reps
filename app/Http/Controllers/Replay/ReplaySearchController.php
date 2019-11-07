<?php

namespace App\Http\Controllers\Replay;

use App\Http\Controllers\Controller;
use App\Models\Replay;
use Illuminate\Http\Request;

class ReplaySearchController extends Controller
{
    public function index()
    {
        return view('replay.search')->with(
            [
                'replay' => $this->searchResult()->get(),
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
            ->orderByDesc('created_at')
            ->where('approved', 1)
            ->where('id', '>', 0)//
        ;

        if (request()->has('text') && request()->filled('text')) {
            $query->where(function ($que) {
                $que->orWhere('title', 'like', '%' . request('text') . '%')
                    ->orWhere('content', 'like', '%' . request('text') . '%');
            });
        }
        if (request()->has('first_country_id') && request()->filled('first_country_id')) {
            $query->where('first_country_id', 'like', '%' . request('first_country_id') . '%');
        }
        if (request()->has('second_country_id') && request()->filled('second_country_id')) {
            $query->where('second_country_id', 'like', '%' . request('second_country_id') . '%');
        }
        if (request()->has('first_race') && request()->filled('first_race')) {
            $query->where('first_race', 'like', '%' . request('first_race') . '%');
        }
        if (request()->has('second_race') && request()->filled('second_race')) {
            $query->where('second_race', 'like', '%' . request('second_race') . '%');
        }
        if (request()->has('map_id') && request()->filled('map_id')) {
            $query->where('map_id', 'like', '%' . request('map_id') . '%');
        }
        if (request()->has('type_id') && request()->filled('type_id')) {
            $query->where('type_id', 'like', '%' . request('type_id') . '%');
        }
        if (request()->has('user_replay') && request()->filled('user_replay')) {
            $query->where('user_replay', 'like', '%' . request('user_replay') . '%');
        }

        return $query;
    }
}
