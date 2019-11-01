<?php

namespace App\Http\Controllers\Replay;

use App\Models\Comment;
use App\Models\Replay;

class ReplayController
{
    public static $REPLAY_PRO = 'replay_pro';

    public static $type;

    public static function getReplays($relations, $user_replay)
    {
        return Replay::with($relations)
            ->withCount('comments')
            ->where('approved', 1)
            ->where('user_replay', $user_replay)
            ->orderByDesc('created_at')
            ->get();
    }

    public static function findUserReplays($relations, $user_id)
    {
        return Replay::with($relations)
            ->withCount('comments')
            ->where('approved', 1)
            ->where('user_id', $user_id)
            ->orderByDesc('created_at')
            ->get();
    }

    public static function findReplay($relations, $id)
    {
        return Replay::with($relations)->withCount('comments')->where('approved', 1)->findOrFail($id);
    }

    public static function getReplaysWithType($relations, $user_replay, $type)
    {
        self::$type = $type;
        return Replay::with($relations)
            ->withCount('comments')
            ->where('approved', 1)
            ->whereHas('types', function ($query) {
                $query->where('name', self::$type);
            })
            ->orderByDesc('created_at')
            ->where('user_replay', $user_replay)
            ->get();
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
            'user_id' => auth()->id(),
            'content' => $request->input('content')
        ]);
        $replay->comments()->save($comment);

        return back();
    }

    public static function loadReplay($relations, $user_replay)
    {
        $request = request();

        if ($request->ajax()) {
            $visible_title = false;
            if ($request->id > 0) {
                $data = Replay::with($relations)
                    ->where('approved', 1)
                    ->where('user_replay', $user_replay)
                    ->where('id', '<', $request->id)
                    ->orderByDesc('created_at')
                    ->limit(5)
                    ->get();
            } else {
                $data = Replay::with($relations)
                    ->where('approved', 1)
                    ->where('user_replay', $user_replay)
                    ->where('id', '<', $request->id)
                    ->orderByDesc('created_at')
                    ->limit(5)
                    ->get();

                $visible_title = true;
            }

            $output = view('replay.index', ['replay' => $data]);
            echo $output;
        }
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
