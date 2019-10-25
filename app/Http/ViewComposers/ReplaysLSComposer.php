<?php


namespace App\Http\ViewComposers;

use Illuminate\View\View;

class ReplaysLSComposer
{
    private static $replayLSPro;
    private static $replayLSUser;
    public static $type;


    public function __construct()
    {
        $data = new GetAllReplay();

        $dataPro = [];
        $dataUser = [];

        $dataPro = $data->getReplayProWithNum(3);
        $dataUser = $data->getReplayUserWithNum(3);

        self::$replayLSPro = $dataPro;
        self::$replayLSUser = $dataUser;

    }

    public function compose(View $view)
    {
        $view->with('replayLSPro', self::$replayLSPro);
        $view->with('replayLSUser', self::$replayLSUser);
        $view->with("replayLSPro" . self::$type, self::$replayLSUser);
    }

    public static function setReplayProType($type)
    {
        self::$type = $type;
        self::$replayLSUser;
    }
}
