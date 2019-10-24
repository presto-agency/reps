<?php


namespace App\Http\ViewComposers;


use App\Models\ReplayType;
use Illuminate\View\View;

class ReplayTypeComposer
{
    public static $replayTypes;


    public function __construct()
    {
        self::$replayTypes = self::getReplayTypes();
    }

    public function compose(View $view)
    {
        $view->with('replayTypes', self::$replayTypes);
    }

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
