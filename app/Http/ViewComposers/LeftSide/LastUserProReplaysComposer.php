<?php


namespace App\Http\ViewComposers\LeftSide;


use App\Models\Replay;
use Cache;
use Illuminate\View\View;

class LastUserProReplaysComposer
{

    private static $column
        = [
            'id', 'title', 'first_race', 'second_race', 'first_country_id',
            'second_country_id',
        ];
    private static $relation
        = [
            'firstCountries:id,flag,name', 'secondCountries:id,flag,name',
            'firstRaces:id,code,title', 'secondRaces:id,code,title',
        ];
    private static $ttl = 300;

    /**
     * @param  View  $view
     */
    public function compose(View $view)
    {
        $view->with('replaysUserLsHome',
            self::getCacheLsReplays('replaysUserLsHome',
                self::getReplaysUser()));
        $view->with('replaysProLsHome',
            self::getCacheLsReplays('replaysProLsHome', self::getReplaysPro()));
    }

    /**
     * @param $cache_name
     *
     * @return mixed
     */
    public static function getCacheLsReplays($cache_name, $data)
    {
        if (Cache::has($cache_name) && ! Cache::get($cache_name)->isEmpty()) {
            $data_cache = Cache::get($cache_name);
        } else {
            $data_cache = Cache::remember($cache_name, self::$ttl,
                function () use ($data) {
                    return $data;
                });
        }

        return $data_cache;
    }


    public static function getReplaysUser()
    {
        $data = Replay::with(self::$relation)
            ->where('approved', 1)
            ->where('user_replay', Replay::REPLAY_USER)
            ->take(4)
            ->get(self::$column);

        return collect($data);
    }


    public static function getReplaysPro()
    {
        $data = Replay::with(self::$relation)
            ->where('approved', 1)
            ->where('user_replay', Replay::REPLAY_PRO)
            ->take(8)
            ->get(self::$column);

        return collect($data);
    }

}
