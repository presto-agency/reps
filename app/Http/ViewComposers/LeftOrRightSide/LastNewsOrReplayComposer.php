<?php


namespace App\Http\ViewComposers\LeftOrRightSide;

use App\Models\ForumTopic;
use App\Models\Replay;
use Illuminate\View\View;


class LastNewsOrReplayComposer
{
    private static $ttl = 300;

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        if (\Route::getCurrentRoute()->uri() == '/') {
            $view->with('dataTitle', 'Последние новости');
            $view->with('data', self::getCacheLast5News('last5News'));
        } else {
            $view->with('dataTitle', 'Последние реплеи');
            $view->with('data', self::getCacheLast5Replay('last5Replays'));
        }
    }

    /**
     * @return mixed
     */
    private static function getLast5Replay()
    {
        return Replay::withCount('comments')
            ->orderByDesc('created_at')
            ->take(5)
            ->get(['id', 'title']);
    }
    /**
     * @return mixed
     */
    private static function getLast5News()
    {
        return ForumTopic::withCount('comments')
            ->orderByDesc('created_at')
            ->take(5)
            ->get(['id', 'title']);
    }

    /**
     * @param $cache_name
     * @return mixed
     */
    public static function getCacheLast5Replay($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function (){
                 return self::getLast5Replay();
            });
        }
        return $data_cache;
    }
    /**
     * @param $cache_name
     * @return mixed
     */
    public static function getCacheLast5News($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self::getLast5News();
            });
        }
        return $data_cache;
    }
}
