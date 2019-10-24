<?php


namespace App\Http\ViewComposers;


use App\Models\Replay;


class GetAllReplay
{
    public static $replayPro;
    public static $replayUser;

    public function __construct()
    {
        self::$replayPro = collect();
        self::$replayUser = collect();

        $relation = [
            'users:id,avatar,name',
            'maps:id,name,url',
            'types',
            'firstCountries:id,name,flag',
            'secondCountries:id,name,flag',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',
        ];
        $getData = Replay::with($relation)->where('approved', 1)->get();
        $dataPro = [];
        $dataUser = [];
        foreach ($getData as $item) {
            if ($item->user_replay == Replay::REPLAY_PRO) {
                $dataPro[] = self::getData($item);
            } else {
                $dataUser[] = self::getData($item);
            }
        }

        self::$replayPro = $dataPro;
        self::$replayUser = $dataUser;
    }


    public function getReplayPro()
    {
        return self::$replayPro;
    }

    public function getReplayUser()
    {
        return self::$replayUser;
    }

    /**
     * @param $item
     * @return array
     */
    public static function getData($item)
    {
        return [
            'userAvatar' => $item->users->avatar,
            'userBlank' => $item->users->avatar_url_or_blank,
            'userName' => $item->users->name,
            'replayCreate' => $item->created_at->format('d.m.Y'),
            'firstCountryFlag25x20' => self::pathToFlag25x20($item->firstCountries->flag),
            'secondCountryFlag25x20' => self::pathToFlag25x20($item->firstCountries->flag),
            'firstRace' => $item->firstRaces->code,
            'secondRace' => $item->secondRaces->code,
            'mapName' => $item->maps->name,
            'mapUrl' => $item->maps->url,
            'replayTitle' => $item->title,
            'replayRait' => $item->positive_count - $item->negative_count,
        ];
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
        $getImgName2 = explode('.', end($getImgName1));
        return $fileName = reset($getImgName2);
    }


}
