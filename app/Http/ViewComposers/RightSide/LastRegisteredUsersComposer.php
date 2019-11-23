<?php


namespace App\Http\ViewComposers\RightSide;

use App\Models\Banner;
use App\User;
use Illuminate\View\View;


class LastRegisteredUsersComposer
{
    private static $ttl = 300;

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('banners', self::getCache('banners', self::getBanners()));
        $view->with('newUsers', self::getCache('newUsers', self::getNewUsers()));
        $view->with('voteRight', self::checkVoteRight());
    }

    /**
     * @return array
     */
    private static function getNewUsers()
    {
        return User::with('countries:id,flag,name', 'races:id,code,title')
            ->latest('created_at')
            ->take(5)
            ->get(['id',
                   'name',
                   'race_id',
                   'country_id']);
    }

    private static function getBanners()
    {
        return Banner::whereNotNull('image')->where('is_active', 1)->get();
    }

    /**
     * @param $cache_name
     * @param $data
     * @return mixed
     */
    public static function getCache($cache_name, $data)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () use ($data) {
                return $data;
            });
        }
        return $data_cache;
    }

    public static function checkVoteRight()
    {
        $url = collect(request()->segments());
        $data = \Str::contains($url, 'user') === true ? false : true;
        return $data;
    }

}
