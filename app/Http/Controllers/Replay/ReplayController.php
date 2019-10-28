<?php

namespace App\Http\Controllers\Replay;

use App\Models\Replay;

class ReplayController
{


    public static function getReplays($ArrRelations, $ArrColumn, $type)
    {
        $data = null;

        $data = Replay::with($ArrRelations)
            ->where('approved', 1)
            ->where('user_replay', $type)
            ->get($ArrColumn);

        return $data;
    }

    public static function findReplay($ArrRelations, $id)
    {
        $data = null;

        $data = Replay::with($ArrRelations)->withCount('comments')->findOrFail($id);

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
}
