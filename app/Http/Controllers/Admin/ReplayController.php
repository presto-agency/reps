<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Replay;
use Illuminate\Http\Request;


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
            'comments'
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

    public function comment(Request $request, $id)
    {
        $topic = Replay::find($id);
        $comment = new Comment([
            'user_id' => auth()->user()->id,
            'content' => $request->input('content'),
        ]);
        $topic->comments()->save($comment);

        return back();
    }

    public function deleteComment($id)
    {
        Comment::find($id)->delete();

        return back();
    }

}
