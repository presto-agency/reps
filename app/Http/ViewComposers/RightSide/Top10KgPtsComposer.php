<?php


namespace App\Http\ViewComposers\RightSide;


use App\User;
use Illuminate\View\View;

class Top10KgPtsComposer
{

    public function compose(View $view)
    {
        $view->with('top10Rating', self::getCache('top10UserRating', self::getTop10UserRating()));
        $view->with('top10Points', self::getCache('top10UserPoints', self::getTop10UserPoints()));
    }

    /**
     * @param $cache_name
     *
     * @return mixed
     */
    public static function getCache($cache_name, $data)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, 300, function () use ($data) {
                return $data;
            });
        }

        return $data_cache;
    }

    public static function getTop10UserRating()
    {
        return User::with('countries:id,flag,name', 'races:id,title')
            ->where('rating', '>=', 0)
            ->orderByDesc('rating')
            ->limit(10)
            ->get(['id', 'name', 'rating', 'race_id', 'country_id']);
    }

    public static function getTop10UserPoints()
    {
        return User::with('countries:id,flag,name', 'races:id,code,title')
            ->withCount('comments')
            ->orderByDesc('comments_count')
            ->limit(10)
            ->get();
    }

}
