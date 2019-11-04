<?php


namespace App\Http\ViewComposers\RightSide;

use App\Models\Replay;
use Illuminate\View\View;


class LastReplayComposer
{
    private static $ttl = 300;

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
//        dd('Последние реплеи');
        $view->with('lastReplaysTitleRight', 'Последние реплеи');
        $view->with('lastReplaysRight', self::getCacheLastReplay('lastReplaysRight'));
    }

    /**
     * @return mixed
     */
    private static function getLastReplay()
    {
        return Replay::withCount('comments')
            ->orderByDesc('created_at')
            ->take(5)
            ->get(['id', 'title']);
    }

    /**
     * @param $cache_name
     * @return mixed
     */
    public static function getCacheLastReplay($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self::getLastReplay();
            });
        }
        return $data_cache;
    }
}
