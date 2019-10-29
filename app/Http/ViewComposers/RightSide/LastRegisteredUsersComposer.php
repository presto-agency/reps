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
        $data = null;

        $getData = User::with('countries:id,flag,name', 'races:id,code,title')
            ->orderBy('id', 'desc')
            ->take(self::$userTake)
            ->get(['id', 'name', 'race_id', 'country_id']);

        if (!$getData->isEmpty()) {
            foreach ($getData as $item) {
                $data[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'raceIcon' => $item->races->title,
                    'raceTitle' => $item->races->title,
                    'countryFlag25x20' => $item->countries->flag,
                    'countryName' => $item->countries->name,
                ];
            }
        }

        return collect($data);
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
