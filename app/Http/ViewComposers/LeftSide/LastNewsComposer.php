<?php


namespace App\Http\ViewComposers\LeftSide;

use App\Models\ForumTopic;
use Illuminate\View\View;


class LastNewsComposer
{
    private static $ttl = 300;

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('lastNewsTitleLeft', 'Последние новости');
        $view->with('lastNewsLeft', self::getCacheLastNews('lastNewsLeft'));
    }


    /**
     * @return mixed
     */
    private static function getLastNews()
    {
        return ForumTopic::withCount('comments')
            ->orderByDesc('id')
            ->take(5)
            ->get(['id', 'title']);
    }

    /**
     * @param $cache_name
     * @return mixed
     */
    public static function getCacheLastNews($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self::getLastNews();
            });
        }
        return $data_cache;
    }
}
