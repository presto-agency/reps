<?php


namespace App\Http\ViewComposers\RightSide;


use App\User;
use Illuminate\View\View;

class Top10KgPtsComposer
{

    public function compose(View $view)
    {

        $view->with('top10Rating', self::getCache('top10Rating',
            self::getTop10Rating()));
        $view->with('top10Points', self::getCache('top10Points',
            self::getTop10Points()));
    }

    /**
     * @param $cache_name
     *
     * @return mixed
     */
    public static function getCache($cache_name, $data)
    {
        if (\Cache::has($cache_name) && ! \Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, 300,
                function () use ($data) {
                    return $data;
                });
        }

        return $data_cache;
    }

    public static function getTop10Rating()
    {
        $data = null;

        $data = User::with('countries:id,flag,name', 'races:id,title')
            ->orderByRaw('(rating) DESC')
            ->whereRaw('(rating) >= 0')
            ->take(10)
            ->get(['id', 'name', 'avatar', 'rating', 'race_id', 'country_id']);

        return collect($data);
    }

    public static function getTop10Points()
    {
        $data = null;

        $data = User::withCount('comments')
            ->orderByDesc('comments_count')
            ->with('countries:id,flag,name', 'races:id,code,title')
            ->take(10)
            ->get();

        return collect($data);
    }

}
