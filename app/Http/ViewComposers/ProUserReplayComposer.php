<?php


namespace App\Http\ViewComposers;

use Illuminate\View\View;

class ProUserReplayComposer
{
    private static $replayPro;
    private static $replayUser;

    public function __construct()
    {
        $data = new GetAllReplay();
        self::$replayPro = $data->get8ReplayPro();
        self::$replayUser = $data->get4ReplayUser();
//        dd(self::$replayPro);
    }

    public function compose(View $view)
    {
        $view->with('replayPro', self::$replayPro);
        $view->with('replayUser', self::$replayUser);
    }
}
