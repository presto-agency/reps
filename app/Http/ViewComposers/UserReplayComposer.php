<?php


namespace App\Http\ViewComposers;

use Illuminate\View\View;

class UserReplayComposer
{
    private static $replayUser;

    public function __construct()
    {
        $data = new GetAllReplay();
        self::$replayUser = $data->getReplayUser();
    }

    public function compose(View $view)
    {

        $view->with('replayUser', self::$replayUser);
    }
}
