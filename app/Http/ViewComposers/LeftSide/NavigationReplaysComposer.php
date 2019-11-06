<?php


namespace App\Http\ViewComposers\LeftSide;


use App\Http\Controllers\Replay\ReplayHelper;
use App\Models\Replay;
use App\Models\ReplayType;
use Illuminate\View\View;

class NavigationReplaysComposer
{

    public static $pro;
    public static $type;
    private static $ttl = 300;
    private static $column = ['id', 'type_id', 'negative_count', 'positive_count', 'created_at', 'approved', 'title'];
    public static $replayTypes = [
        '1x1' => 'duel',
        'Park / Archive' => 'pack',
        'Game of the Week' => 'gotw',
        '2x2, 3x3, 4x4' => 'team',
    ];
    public $replayNav;
    public static $replayTypeName;

    public function __construct()
    {
        self::$pro = ReplayHelper::checkUrlType() === 1 ? true : false;
        self::$type = ReplayHelper::checkUrlType() == Replay::REPLAY_USER ? 'pro' : 'user';
        self::$replayTypeName = ReplayHelper::checkUrlType() === 1 ? 'Пользовательские' : 'Профессиональные';
//        if (ReplayHelper::checkUrlType() == 1) {
            $this->replayNav = self::getCacheReplayPro('proReplayNav');
//        } else {
//            $this->replayNav = self::getCacheReplayUser('userReplayNav');
//        }
    }

    public function compose(View $view)
    {

        $view->with("pro", self::$pro);
        $view->with("type", self::$type);
        $view->with("replayTypeName", self::$replayTypeName);
        $view->with("replayTypes", self::$replayTypes);
        $view->with("replayNav", $this->replayNav);

    }

    public static function getCacheReplayUser($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self::getReplayUser();
            });
        }
        return $data_cache;
    }

    public static function getCacheReplayPro($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self::getReplayTypeWithReplays();
            });
        }
        return $data_cache;
    }

    private static function getReplayTypeWithReplays()
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

    public static function getReplayUser()
    {

        return Replay::with('types:id,name')
            ->where('approved', 1)
            ->where('user_replay', Replay::REPLAY_USER)
            ->orderByDesc('created_at')
            ->take(3)
            ->get(self::$column);
    }
}
