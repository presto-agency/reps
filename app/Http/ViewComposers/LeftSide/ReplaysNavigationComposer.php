<?php


namespace App\Http\ViewComposers\LeftSide;


use App\Models\ReplayType;
use Illuminate\View\View;

class ReplaysNavigationComposer
{
    private static $replayLS;
    public static $pro;


    public function __construct()
    {
        self::$pro = collect(request()->segments())->last() != 'pro' ? true : false;
    }

    public function compose(View $view)
    {
        $view->with("pro", self::$pro);
//        $view->with("replayLS" . self::$type, self::$replayLS);
    }


    public static $replayTypes;


    public static function getReplayTypes()
    {
        $dataType = [];

        $dataTypes = ReplayType::all(['id', 'name', 'title']);
        if (!$dataTypes->isEmpty()) {
            foreach ($dataTypes as $item) {
                $dataType[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'title' => $item->title,
                    'url' => "replay\pro\\" . $item->name,
                ];
            }
        }
        return $dataType;
    }
}
