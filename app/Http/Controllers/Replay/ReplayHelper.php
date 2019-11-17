<?php

namespace App\Http\Controllers\Replay;

use App\Models\Comment;
use App\Models\Replay;
use Illuminate\Http\Request;

class ReplayHelper
{
    public static $USER_REPLAY_URL = 'user-replay';

    /**
     * Get user replay withType2
     *
     * @param $relations
     * @param $id
     * @param $user_replay
     * @return Replay|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public static function findReplayWithType2($relations, $id, $user_replay)
    {
        return Replay::with($relations)
            ->withCount('comments')
            ->with(['comments.user' => function ($query) {
                $query->withCount('comments');
            }])
            ->with(['users' => function ($query) {
                $query->withCount('comments');
            }])
            ->where('user_replay', $user_replay)
            ->where('approved', 1)
            ->findOrFail($id);

    }

    public static function findReplaysWithType($relations, $id, $user_replay, $type)
    {

        return Replay::with($relations)
            ->withCount('comments')
            ->with(['comments.user' => function ($query) {
                $query->withCount('comments');
            }])
            ->with(['users' => function ($query) {
                $query->withCount('comments');
            }])
            ->where('approved', 1)
            ->whereHas('types', function ($query) use ($type) {
                $query->where('name', $type);
            })
            ->where('user_replay', $user_replay)
            ->findOrFail($id);
    }

    public function download()
    {
        $request = request();
        $filePath = Replay::find($request->id)->value('file');

        if (\File::exists($filePath)) {
            return response()->download($filePath);
        }
        return back();
    }

    public function downloadCount()
    {
        $request = request();
        if ($request->ajax()) {
            $filePath = Replay::find($request->id)->value('file');
            if (\File::exists($filePath)) {
                $replay = Replay::find($request->id);
                $replay->increment('downloaded', 1);
                $replay->save();
                echo json_encode(array('downloaded' => $replay->downloaded));
            }
        }
    }

    public function saveComments()
    {
        $replay = Replay::find(request('id'));
        $comment = new Comment([
            'user_id' => auth()->id(),
            'content' => request('content'),
        ]);
        $replay->comments()->save($comment);

        return back();
    }

    public static function getReplayType()
    {

        if (request()->has('type') && request()->filled('type')) {
            if (request('type') === 'user') {
                return $type = Replay::REPLAY_USER;
            } elseif (request('type') === 'pro') {
                return $type = Replay::REPLAY_PRO;
            } else {
                return $type = Replay::REPLAY_USER;
            }
        } else {
            return $type = Replay::REPLAY_USER;
        }
    }

    public static function getUrl()
    {
        return collect(request()->segments());
    }

    public static function checkUrl()
    {
        return \Str::contains(self::getUrl(), "user-replay");
    }

    public static function checkUrlType()
    {
        return self::getReplayType();
    }
}
