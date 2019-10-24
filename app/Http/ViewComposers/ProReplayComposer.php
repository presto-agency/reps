<?php


namespace App\Http\ViewComposers;


use Illuminate\View\View;

class ProReplayComposer
{
    public static $replayPro;

    public function __construct()
    {
        $data = new GetAllReplay();
//        dd($data->getReplayPro());
        self::$replayPro = $data->getReplayPro();
    }

    public function compose(View $view)
    {

        $view->with('replayPro', self::$replayPro);
    }
}
