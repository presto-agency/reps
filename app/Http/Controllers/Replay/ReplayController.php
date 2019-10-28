<?php

namespace App\Http\Controllers\Replay;

use App\Models\Comment;
use App\Models\Replay;

class ReplayController
{

    public static $type;

    public static function getReplays($ArrRelations, $ArrColumn, $user_replay)
    {
        $data = null;

        $data = Replay::with($ArrRelations)
            ->where('approved', 1)
            ->where('user_replay', $user_replay)
            ->orderByDesc('created_at')
            ->get($ArrColumn);

        return $data;
    }

    public static function findReplay($ArrRelations, $id)
    {
        $data = null;

        $data = Replay::with($ArrRelations)->withCount('comments')->findOrFail($id);

        return $data;
    }

    public static function getReplaysWithType($ArrRelations, $ArrColumn, $user_replay, $type)
    {
        $data = null;

        self::$type = $type;

        $data = Replay::with($ArrRelations)
            ->where('approved', 1)
            ->whereHas('types', function ($query) {
                $query->where('name', self::$type);
            })
            ->where('user_replay', $user_replay)
            ->get($ArrColumn);

        return $data;
    }

    public function download()
    {
        $request = request();

        $filePath = Replay::findOrFail($request->id)->value('file');
        if (\File::exists($filePath)) {
            return response()->download($filePath);
        } else {
            return 'Файл отсутствует';
        }
    }

    public function downloadCount()
    {
        $request = request();

        if ($request->ajax()) {
            $replay = Replay::findOrFail($request->id);
            $replay->increment('downloaded', 1);
            $replay->save();

            echo json_encode(array('downloaded' => $replay->downloaded));
        }
    }

    public function saveComments()
    {
        $request = request();
        $replay = Replay::find($request->id);
        $comment = new Comment([
            'user_id' => self::getAuthUser()->id,
            'content' => $request->input('content')
        ]);
        $replay->comments()->save($comment);

        return back();
    }

    public static function loadReplay($ArrRelations, $ArrColumn, $user_replay)
    {
        $request = request();

        if ($request->ajax()) {
            $visible_title = false;
            if ($request->id > 0) {
                $data = Replay::with($ArrRelations)
                    ->where('approved', 1)
                    ->where('user_replay', $user_replay)
                    ->where('id', '<', $request->id)
                    ->orderByDesc('created_at')
                    ->limit(5)
                    ->get($ArrColumn);
            } else {
                $data = Replay::with($ArrRelations)
                    ->where('approved', 1)
                    ->where('user_replay', $user_replay)
                    ->where('id', '<', $request->id)
                    ->orderByDesc('created_at')
                    ->limit(5)
                    ->get($ArrColumn);

                $visible_title = true;
            }

            $output = view('replay.index', ['replay' => $data]);
            echo $output;
        }
    }

    public static function getAuthUser()
    {
        return auth()->user();
    }

    public static function getUrl()
    {
        return collect(request()->segments());
    }

    public static function checkUrlTournament()
    {
        return \Str::contains(self::getUrl(), 'tournament');
    }

    public static function checkUrlPro()
    {
        return \Str::contains(self::getUrl(), 'replay_pro');
    }

    public static function checkUrlProType($type)
    {
        return \Str::contains(self::getUrl(), "$type");
    }
}
