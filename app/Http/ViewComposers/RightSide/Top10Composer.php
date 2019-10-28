<?php


namespace App\Http\ViewComposers\RightSide;


use App\User;
use Illuminate\View\View;

class Top10Composer
{
    private static $ttl = 300;

    public function compose(View $view)
    {
        $view->with('top10Rating', self::getCacheRating('top10Rating'));
        $view->with('top10Points', self::getCachePoints('top10Points'));
    }

    /**
     * @param $cache_name
     * @return mixed
     */
    public static function getCacheRating($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self::getTop10Rating();
            });
        }
        return $data_cache;
    }

    /**
     * @param $cache_name
     * @return mixed
     */
    public static function getCachePoints($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self::getTop10Points();
            });
        }
        return $data_cache;
    }

    public static function getTop10Rating()
    {
        $data = null;

        $getData = User::orderByRaw("(count_positive - count_negative) DESC")
            ->whereRaw("(count_positive - count_negative) >= 0")
            ->with('countries:id,flag', 'races:id,title')
            ->take(10)
            ->get();

        if (!$getData->isEmpty()) {
            $data = self::getDataArray($getData, 'rating');
        }

        return collect($data);
    }

    public static function getTop10Points()
    {
        $data = null;

        $getData = User::withCount('totalComments')
            ->orderByDesc('total_comments_count')
            ->with('countries:id,flag', 'races:id,title')
            ->take(10)
            ->get();

        if (!$getData->isEmpty()) {
            $data = self::getDataArray($getData, 'comments');
        }

        return collect($data);
    }

    /**
     * @param $setData
     * @param $type
     * @return array
     */
    public static function getDataArray($setData, $type)
    {
        $data = null;

        foreach ($setData as $item) {
            $data[] = [
                'id' => $item->id,
                'name' => $item->name,
                'avatar' => self::checkAvatar($item),
                'raceIcon' => "images\\" . $item->races->title . ".png",
                'countryFlag25x20' => $item->countries->flag,
                'max' => self::setMaxType($type, $item),
            ];
        }
        return $data;

    }

    /**
     * @param $item
     * @return mixed
     */
    public static function checkAvatar($item)
    {
        return \File::exists($item->avatar) === true ? $item->avatar : $item->avatar_url_or_blank;
    }

    /**
     * @param $type
     * @param $item
     * @return |null
     */
    public
    static function setMaxType($type, $item)
    {
        switch ($type) {
            case 'comments':
                return $item->total_comments_count;
                break;
            case 'rating':
                return $item->count_positive - $item->count_negative;
                break;
            case 'news':
                return $item->total_news_count;
                break;
            case 'replays':
                return $item->total_replays_count;
                break;
            default:
                return null;
                break;
        }
    }
}
