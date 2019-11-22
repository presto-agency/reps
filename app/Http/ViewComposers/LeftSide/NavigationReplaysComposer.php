<?php


namespace App\Http\ViewComposers\LeftSide;


use App\Http\Controllers\Replay\ReplayHelper;
use App\Models\Replay;
use App\Models\ReplayType;
use Cache;
use Illuminate\View\View;

class NavigationReplaysComposer
{

    public static $pro;
    public static $type;
    private static $column
        = [
            'id', 'type_id', 'negative_count', 'positive_count', 'created_at',
            'approved', 'title',
        ];
    public static $replayTypes
        = [
            '1x1'              => 'duel',
            'Park / Archive'   => 'pack',
            'Game of the Week' => 'gotw',
            '2x2, 3x3, 4x4'    => 'team',
        ];
    public $replayNav;
    public static $replayTypeName;

    public function __construct()
    {
        self::$pro = ReplayHelper::checkUrlType() == 1 ? true
            : false;

        self::$type = ReplayHelper::checkUrlType()
        == Replay::REPLAY_USER ? 'pro' : 'user';

        self::$replayTypeName = ReplayHelper::checkUrlType() == 1
            ? 'Пользовательские' : 'Профессиональные';
        $this->replayNav      = self::getCacheReplayPro('proReplayNav');

    }

    public function compose(View $view)
    {
        $view->with("pro", self::$pro);
        $view->with("type", self::$type);
        $view->with("replayTypeName", self::$replayTypeName);
        $view->with("replayTypes", self::$replayTypes);
        $view->with("replayNav", $this->replayNav);

    }

    private static function getCacheReplayPro($cache_name)
    {
        if (Cache::has($cache_name) && ! Cache::get($cache_name)->isEmpty()) {
            $data_cache = Cache::get($cache_name);
        } else {
            $data_cache = Cache::remember($cache_name, 300,
                function () {
                    return self::getReplay();
                });
        }

        return $data_cache;
    }

    //    private static function getReplay2(){
    //        return ReplayType::with(['replays' => function ($query) {
    //            $query->where('approved', 1)
    //                ->withCount('comments')
    //                ->where('user_replay', Replay::REPLAY_PRO)
    //                ->take(4);
    //       }])->get();
    //    }

    private static function getReplay()
    {
        return ReplayType::with('replays')->get()->map(function ($query) {
            $query->setRelation('replays',
                $query->replays->where('approved', 1)
                    ->where('user_replay', Replay::REPLAY_PRO)
                    ->take(3)
            )->orderByDesc('created_at');

            return $query;
        });
    }

}
