<?php

namespace App\Http\Controllers\Best;

use App\Http\Controllers\Controller;
use App\User;

class BestController extends Controller
{
    public static $top100 = 100;

    public function show()
    {
        $checkProLS = true;

        $top100Points = $this->getTop100Points();
        $top100Rating = $this->getTop100Rating();
        $top100News = $this->getTop100News();
        $top100Replay = $this->getTop100Replay();

        return view('best.index',
            compact('checkProLS', 'top100Points', 'top100Rating', 'top100News', 'top100Replay')
        );
    }

    public function getTop100Points()
    {
        $data = null;

        $getData = User::with('countries:id,flag', 'races:id,title')
            ->withCount('totalComments')
            ->orderByDesc('total_comments_count')
            ->take(self::$top100)
            ->get();

        if (!$getData->isEmpty()) {
            $data = self::getDataArray($getData, 'comments');
        }

        return $data;
    }

    public function getTop100Rating()
    {
        $data = null;

        $getData = User::with('countries:id,flag', 'races:id,title')
            ->orderByRaw("(count_positive - count_negative) DESC")
            ->whereRaw("(count_positive - count_negative) >= 0")
            ->take(self::$top100)
            ->get();

        if (!$getData->isEmpty()) {
            $data = self::getDataArray($getData, 'rating');
        }

        return $data;
    }

    public function getTop100News()
    {
        $data = null;

        $getData = User::with('countries:id,flag', 'races:id,title')
            ->withCount('totalNews')
            ->orderByDesc('total_news_count')
            ->take(self::$top100)
            ->get();
        if (!$getData->isEmpty()) {
            $data = self::getDataArray($getData, 'news');
        }

        return $data;
    }

    public function getTop100Replay()
    {
        $data = null;

        $getData = User::with('countries:id,flag', 'races:id,title')
            ->withCount('totalReplays')
            ->orderByDesc('total_replays_count')
            ->take(self::$top100)
            ->get();
        if (!$getData->isEmpty()) {
            $data = self::getDataArray($getData, 'replays');
        }

        return $data;
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
