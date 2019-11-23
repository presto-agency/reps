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
            $data_cache = \Cache::remember($cache_name, 300, function () use ($data) {
                return $data;
            });
        }

        return $data_cache;
    }

    public static function getTop10Rating()
    {
        $data = null;

        $getData = User::with('countries:id,flag,name', 'races:id,code,title')
            ->orderByRaw("(rating) DESC")
            ->whereRaw("(rating) >= 0")
            ->take(10)
            ->get(['id','name','avatar','rating','race_id','country_id']);

        if ( ! $getData->isEmpty()) {
            $data = self::getDataArray($getData, 'rating');
        }

        return collect($data);
    }

    public static function getTop10Points()
    {
        $data = null;

        $getData = User::withCount('comments')
            ->orderByDesc('comments_count')
            ->with('countries:id,flag,name', 'races:id,code,title')
            ->take(10)
            ->get();

        if ( ! $getData->isEmpty()) {
            $data = self::getDataArray($getData, 'comments');
        }

        return collect($data);
    }

    /**
     * @param $setData
     * @param $type
     *
     * @return array
     */
    public static function getDataArray($setData, $type)
    {
        $data = null;

        foreach ($setData as $item) {
            $data[] = [
                'id'               => $item->id,
                'name'             => $item->name,
                'avatar'           => $item->avatar,
                'raceIcon'         => "images/default/game-races/"
                    .$item->races->title.".png",
                'raceTitle'        => $item->races->title,
                'countryFlag25x20' => $item->countries->flagOrDefault(),
                'countryName'      => $item->countries->name,
                'max'              => self::setMaxType($type, $item),
            ];
        }

        return $data;

    }

    /**
     * @param $type
     * @param $item
     *
     * @return |null
     */
    public
    static function setMaxType(
        $type,
        $item
    ) {
        switch ($type) {
            case 'comments':
                return $item->comments_count;
                break;
            case 'rating':
                return $item->rating;
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
