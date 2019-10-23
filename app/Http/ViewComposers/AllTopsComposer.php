<?php


namespace App\Http\ViewComposers;

use App\User;
use Illuminate\View\View;

class AllTopsComposer
{
    private $getTop100Points;
    private $getTop100Rating;
    private $getTop100News;
    private $getTop100Replay;

    private $getTop10Rating;
    private $getTop10Points;


    public function __construct()
    {
        $this->getTop100Points = collect();
        $this->getTop100Rating = collect();
        $this->getTop100Replay = collect();
        $this->getTop100News = collect();

        $setTop100Points = self::getTop100Points();
        $setTop100Rating = self::getTop100Rating();
        $setTop100Replay = self::getTop100Replay();
        $setTop100News = self::getTop100News();

        $this->getTop100Points = $setTop100Points;
        $this->getTop100Rating = $setTop100Rating;
        $this->getTop100Replay = $setTop100Replay;
        $this->getTop100News = $setTop100News;

        $this->getTop10Rating = collect();
        $this->getTop10Points = collect();

        $this->getTop10Rating = array_slice($setTop100Rating, 0, 9);
        $this->getTop10Points = array_slice($setTop100Points, 0, 9);
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('top100Points', $this->getTop100Points);
        $view->with('top100Rating', $this->getTop100Rating);
        $view->with('top100Replay', $this->getTop100Replay);
        $view->with('top100News', $this->getTop100News);

        $view->with('top10Rating', $this->getTop10Rating);
        $view->with('top10Points', $this->getTop10Points);

    }

    /**
     * @return array
     */
    public static function getTop100Points()
    {
        $data = [];

        $getData = User::withCount('totalComments')
            ->orderByDesc('total_comments_count')
            ->with('countries:id,flag', 'races:id,title')
            ->take(100)
            ->get();
        if (!$getData->isEmpty()) {
            $data = self::getDataArray($getData, 'comments');
        }

        return $data;
    }

    /**
     * @return array
     */
    public static function getTop100Rating()
    {
        $data = [];

        $getData = User::orderByRaw("(count_positive - count_negative) DESC")
            ->whereRaw("(count_positive - count_negative) >= 0")
            ->with('countries:id,flag', 'races:id,title')
            ->take(100)
            ->get();
        if (!$getData->isEmpty()) {
            $data = self::getDataArray($getData, 'rating');
        }

        return $data;
    }

    /**
     * @return array
     */
    public static function getTop100News()
    {
        $data = [];

        $getData = User::withCount('totalNews')
            ->orderByDesc('total_news_count')
            ->with('countries:id,flag', 'races:id,title')
            ->take(100)
            ->get();
        if (!$getData->isEmpty()) {
            $data = self::getDataArray($getData, 'news');
        }

        return $data;
    }

    /**
     * @return array
     */
    public static function getTop100Replay()
    {
        $data = [];

        $getData = User::withCount('totalReplays')
            ->orderByDesc('total_replays_count')
            ->with('countries:id,flag', 'races:id,title')
            ->take(100)
            ->get();
        if (!$getData->isEmpty()) {
            $data = self::getDataArray($getData, 'replays');
        }

        return $data;
    }

    /**
     * @param $filePath
     * @return string
     */
    public static function pathToFlag25x20($filePath)
    {
        $ext = ".png";
        $filename = self::getFileName($filePath);
        return "storage/image/county/flag/25x20/$filename$ext";
    }

    /**
     * @param $filePath
     * @return mixed
     */
    public static function getFileName($filePath)
    {
        $getImgName1 = explode('/', $filePath);
        $end = end($getImgName1);
        $getImgName2 = explode('.', $end);
        return $fileName = reset($getImgName2);
    }

    /**
     * @param $setData
     * @param $type
     * @return array
     */
    public static function getDataArray($setData, $type)
    {
        $data = [];

        foreach ($setData as $item) {
            $data[] = [
                'id' => $item->id,
                'name' => $item->name,
                'avatar' => $item->avatar ?? $item->avatar_url_or_blank,
                'raceIcon' => "images\\" . $item->races->title . ".png",
                'countryFlag25x20' => self::pathToFlag25x20($item->countries->flag),
                'max' => self::setMaxType($type, $item),
            ];
        }
        return $data;

    }

    /**
     * @param $type
     * @param $item
     * @return null
     */
    public static function setMaxType($type, $item)
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
