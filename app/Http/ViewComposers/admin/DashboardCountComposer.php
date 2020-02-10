<?php


namespace App\Http\ViewComposers\admin;

use App\Models\ForumTopic;
use App\Models\Replay;
use App\User;
use Cache;
use Illuminate\View\View;

class DashboardCountComposer
{
    private static $ttl = 600;
    private $category;

    public function __construct()
    {
        $data['users'] = self::getCacheUser();
        $data['forumTopics'] = self::getCacheForumTopics();
        $data['countUser'] = self::getCacheUserReplay();
        $data['countGosu'] = self::getCacheGosuReplay();
        $data['gosuId'] = Replay::REPLAY_PRO;
        $data['userId'] = Replay::REPLAY_USER;

        $this->category = $data;

    }

    public function compose(View $view)
    {
        $view->with('data', $this->category);
    }


    public static function getCacheUser()
    {
        $cache_name = 'dashboardUsersCount';
        if (Cache::has($cache_name) && !empty(Cache::get($cache_name))) {
            $data_cache = Cache::get($cache_name);
        } else {
            $data_cache = Cache::remember($cache_name, self::$ttl, function () {
                return User::count();
            });
        }
        return $data_cache;
    }

    public static function getCacheForumTopics()
    {
        $cache_name = 'dashboardForumTopics';
        if (Cache::has($cache_name) && !empty(Cache::get($cache_name))) {
            $data_cache = Cache::get($cache_name);
        } else {
            $data_cache = Cache::remember($cache_name, self::$ttl, function () {
                return ForumTopic::query()->count();
            });
        }
        return $data_cache;
    }

    public static function getCacheUserReplay()
    {
        $cache_name = 'dashboardUserReplay';
        if (Cache::has($cache_name) && !empty(Cache::get($cache_name))) {
            $data_cache = Cache::get($cache_name);
        } else {
            $data_cache = Cache::remember($cache_name, self::$ttl, function () {
                return Replay::where('user_replay', Replay::REPLAY_USER)->count();
            });
        }
        return $data_cache;
    }

    public static function getCacheGosuReplay()
    {
        $cache_name = 'dashboardGosuReplay';
        if (Cache::has($cache_name) && !empty(Cache::get($cache_name))) {
            $data_cache = Cache::get($cache_name);
        } else {
            $data_cache = Cache::remember($cache_name, self::$ttl, function () {
                return Replay::where('user_replay', Replay::REPLAY_PRO)->count();
            });
        }
        return $data_cache;
    }
}
