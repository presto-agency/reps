<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Http\Controllers\Controller;
use App\Models\Replay;


class ReplayController extends Controller
{
    public function show($id)
    {

        $columns = [
            'id',
            'map_id',
            'user_replay',
            'first_country_id',
            'second_country_id',
            'first_race',
            'second_race',
            'first_name',
            'second_name',
            'first_location',
            'second_location',
            'start_date',
            'user_rating',
            'approved',
            'file',
            'content',
        ];
        $relations = [
            'maps',
            'firstCountries',
            'secondCountries',
            'firstRaces',
            'secondRaces',
        ];
        $replay = Replay::select($columns)->with($relations)->findOrFail($id);


        $content = view('admin.replays.show',
            compact('replay')
        );

        return AdminSection::view($content, 'Replay');
    }

    public function download($id)
    {
        $filePath = Replay::findOrFail($id)->value('file');

        return response()->download($filePath);

    }
}
