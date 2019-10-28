<?php


namespace App\Http\ViewComposers\LeftSide;


use App\Http\Controllers\Replay\ReplayController;
use App\Models\Replay;
use Illuminate\View\View;

class ReplaysNavigationComposer
{

    public static $pro;
    private static $ttl = 300;
    public static $replayTypes = [
        '1x1' => 'duel',
        'Park / Archive' => 'pack',
        'Game of the Week' => 'gotw',
        '2x2, 3x3, 4x4' => 'team',
    ];
    public static $replayNav;
    public static $replayTypeName;

    public function __construct()
    {
        self::$pro = ReplayController::checkUrlPro() === false ? true : false;
        self::$replayTypeName = ReplayController::checkUrlPro() === true ? $replayTypeName = "Профессиональные" : $replayTypeName = "Пользовательские";
        self::$replayTypeName = ReplayController::checkUrlTournament() === true ? $replayTypeName = "Профессиональные" : self::$replayTypeName;

        if (ReplayController::checkUrlPro() === false) {
            $data1 = self::getCacheReplayProDuel('replayProDuel')->toArray();
            $data2 = self::getCacheReplayProPack('replayProPack')->toArray();
            $data3 = self::getCacheReplayProGotw('replayProGotw')->toArray();
            $data4 = self::getCacheReplayProTeam('replayProTeam')->toArray();
            self::$replayNav = array_merge($data1, $data2, $data3, $data4);
        } else {
            self::$replayNav = self::getCacheReplayUser('replayUser')->toArray();
        };
    }

    public function compose(View $view)
    {
        $view->with("pro", self::$pro);
        $view->with("replayTypes", self::$replayTypes);
        $view->with("replayNav", self::$replayNav);
        $view->with("replayTypeName", self::$replayTypeName);
    }

    /**
     * @param $cache_name
     * @return mixed
     */
    public static function getCacheReplayProDuel($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, 300, function () {
                return self::getReplayProDuel();
            });
        }
        return $data_cache;
    }

    /**
     * @param $cache_name
     * @return mixed
     */
    public static function getCacheReplayProPack($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self::getReplayProPack();
            });
        }
        return $data_cache;
    }

    /**
     * @param $cache_name
     * @return mixed
     */
    public static function getCacheReplayProGotw($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self::getReplayProGotw();
            });
        }
        return $data_cache;
    }

    /**
     * @param $cache_name
     * @return mixed
     */
    public static function getCacheReplayProTeam($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self::getReplayProTeam();
            });
        }
        return $data_cache;
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

    /**
     * @return \Illuminate\Support\Collection
     */
    private static function getReplayProDuel()
    {
        $data = null;
        $column = ['id', 'type_id', 'negative_count', 'positive_count', 'first_name', 'second_name', 'created_at', 'approved'];
        $data = Replay::with('types:id,name')
            ->where('approved', 1)
            ->where('user_replay', Replay::REPLAY_PRO)
            ->whereHas('types', function ($query) {
                $query->where('name', 'duel');
            })
            ->orderByDesc('created_at')
            ->take(3)
            ->get($column);

        return collect($data);
    }

    private static function getReplayProPack()
    {
        $data = null;
        $column = ['id', 'type_id', 'negative_count', 'positive_count', 'first_name', 'second_name', 'created_at', 'approved'];
        $data = Replay::with('types:id,name')
            ->where('approved', 1)
            ->where('user_replay', Replay::REPLAY_PRO)
            ->whereHas('types', function ($query) {
                $query->where('name', 'pack');
            })
            ->orderByDesc('created_at')
            ->take(3)
            ->get($column);

        return collect($data);
    }

    private static function getReplayProGotw()
    {
        $data = null;
        $column = ['id', 'type_id', 'negative_count', 'positive_count', 'first_name', 'second_name', 'created_at', 'approved'];
        $data = Replay::with('types:id,name')
            ->where('approved', 1)
            ->where('user_replay', Replay::REPLAY_PRO)
            ->whereHas('types', function ($query) {
                $query->where('name', 'gotw');
            })
            ->orderByDesc('created_at')
            ->take(3)
            ->get($column);

        return collect($data);
    }

    private static function getReplayProTeam()
    {
        $data = null;
        $column = ['id', 'type_id', 'negative_count', 'positive_count', 'first_name', 'second_name', 'created_at', 'approved'];
        $data = Replay::with('types:id,name')
            ->where('approved', 1)
            ->where('user_replay', Replay::REPLAY_PRO)
            ->whereHas('types', function ($query) {
                $query->where('name', 'team');
            })
            ->orderByDesc('created_at')
            ->take(3)
            ->get($column);

        return collect($data);
    }

    public static function getReplayUser()
    {
        $data = null;
        $column = ['id', 'type_id', 'negative_count', 'positive_count', 'first_name', 'second_name', 'created_at', 'approved'];
        $data = Replay::with('types:id,name')
            ->where('approved', 1)
            ->where('user_replay', Replay::REPLAY_USER)
            ->orderByDesc('created_at')
            ->take(3)
            ->get($column);

        return collect($data);
    }
}
