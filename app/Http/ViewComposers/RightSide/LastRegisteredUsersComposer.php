<?php


namespace App\Http\ViewComposers\RightSide;

use App\User;
use Illuminate\View\View;


class LastRegisteredUsersComposer
{
    private static $userTake = 5;
    private static $ttl = 300;

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $result = self::getCache('newUsers');
        $view->with('newUsers', $result);
        $view->with('voteRight', self::checkVoteRight());
    }

    /**
     * @return array
     */
    private static function getNewUsers()
    {
        return User::with('countries:id,flag,name', 'races:id,code,title')
            ->orderByDesc('created_at')
            ->take(self::$userTake)
            ->get(['id', 'name', 'race_id', 'country_id']);
    }

    /**
     * @param $cache_name
     * @return mixed
     */
    public static function getCache($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self::getNewUsers();
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
