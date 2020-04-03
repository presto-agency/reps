<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Events\ReplayDownload;
use App\Http\Controllers\Controller;
use App\Models\{Comment, Replay};
use File;
use Illuminate\Http\Request;
use Storage;
use Str;

class ReplayController extends Controller
{

    public function show($id)
    {

        $replay    = Replay::with([
            'users',
            'users.countries:id,name,flag',
            'users.races:id,title',
            'users'         => function ($query) {
                $query->withCount('comments');
            },
            'maps:id,name,url',
            'types:id,name,title',
            'firstCountries:id,name,flag,name',
            'secondCountries:id,name,flag,name',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',

            'comments',
            'comments.user:id,avatar,name,country_id,race_id,rating,count_negative,count_positive',
            'comments.user.countries:id,name,flag',
            'comments.user.races:id,title',
            'comments.user' => function ($query) {
                $query->withCount('comments');
            },
        ])->withCount('comments')->findOrFail($id);

        $content = view('admin.replays.show', compact('replay'));

        return AdminSection::view($content, 'Replay');
    }

    public function download($id)
    {
        $replay   = Replay::where('id', $id)->firstOrFail();
        $filePath = $replay->file;
        if (empty($filePath)) {
            return back();
        }
        if (strpos($filePath, '/storage') !== false) {
            $filePath = Str::replaceFirst('/storage', 'public', $filePath);
        }
        if (strpos($filePath, 'storage') !== false) {
            $filePath = Str::replaceFirst('storage', 'public', $filePath);
        }

        $checkPath = Storage::path($filePath);
        if (File::exists($checkPath) === false) {
            return back();
        };
        self::downloadCount($replay);

        return response()->download($checkPath);
    }

    public static function downloadCount($replay)
    {
        $replay->increment('downloaded', 1);
        $replay->save();
    }


    public function comment(Request $request, $id)
    {
        $topic   = Replay::query()->findOrFail($id);
        $comment = new Comment([
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);
        $topic->comments()->save($comment);

        return back();
    }

    public function deleteComment($id)
    {
        Comment::query()->where('id',$id)->delete();

        return back();
    }

}
