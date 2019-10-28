<?php


namespace App\Http\ViewComposers\LeftSide;


use App\Http\Controllers\Replay\ReplayController;
use App\Models\ReplayType;
use Illuminate\View\View;

class ReplaysNavigationComposer
{

    public static $pro;
    public static $replayTypes = [
        'duel',
        'pack',
        'gotw',
        'team',
    ];
    public static $replayNav;

    public function __construct()
    {
        self::$pro = ReplayController::checkUrlPro() === false ? true : false;


        $data1 = ReplayController::getReplayProDuel();
        $data2 = ReplayController::getReplayProPack();
        $data3 = ReplayController::getReplayProGotw();
        $data4 = ReplayController::getReplayProTeam();
        self::$replayNav = array_merge($data1, $data2, $data3, $data4);


//dd($data1,$data2,$data3,$data4);

    }

    public function compose(View $view)
    {
        $view->with("pro", self::$pro);
        $view->with("replayTypes", self::getReplayTypes());
        $view->with("replayNav", self::$replayNav);
    }

    /**
     * @return array
     */
    private static function getReplayTypes()
    {
        $data = null;
        $getData = ReplayType::all();
        if (!$getData->isEmpty()) {
            foreach ($getData as $item) {
                $data[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'title' => $item->title,
                ];
            }
        }
        return $data;
    }
}
