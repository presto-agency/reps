<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Events\ReplayDownload;
use App\Http\Controllers\Controller;
use App\Models\{Comment, Replay};
use Illuminate\Http\Request;

class ReplayController extends Controller
{
    public function show($id)
    {

        $columns = [
            'id',
            'map_id',
            'title',
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
        event(new ReplayDownload($id));
        $filePath = Replay::findOrFail($id)->value('file');
        if (\Storage::exists($filePath)) {
            return response()->download($filePath);
        } else {
            return 'Файл отсутствует';
        }
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
