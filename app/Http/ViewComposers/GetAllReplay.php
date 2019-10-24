<?php


namespace App\Http\ViewComposers;


use App\Models\Replay;
use phpDocumentor\Reflection\Type;


class GetAllReplay
{
    public static $replayPro;
    public static $replayUser;

    public function __construct()
    {

        $relation = [
            'users:id,avatar,name',
            'maps:id,name,url',
            'types:id,name,title',
            'firstCountries:id,name,flag',
            'secondCountries:id,name,flag',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',
        ];
        $getData = Replay::with($relation)->where('approved', 1)->get();
        $dataPro = [];
        $dataUser = [];
        if (!$getData->isEmpty()) {
            foreach ($getData as $item) {
                if ($item->user_replay == Replay::REPLAY_PRO) {
                    $dataPro[] = self::getData($item);
                } else {
                    $dataUser[] = self::getData($item);
                }
            }
        }

        $dataAll = array_merge($dataPro, $dataUser);
//        self::getReplayProWithNumType($num, $type);
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

    public function getReplayUserWithNum($num)
    {
        return array_slice(self::$replayUser, 0, $num);
    }

    public function getReplayProWithNum($num)
    {
        return array_slice(self::$replayPro, 0, $num);
    }

    public static function getReplayProWithNumType($num, $type)
    {
        return null;
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
            'firstCountryFlag25x20' => $item->firstCountries->flag,
            'secondCountryFlag25x20' => $item->firstCountries->flag,
            'firstRace' => $item->firstRaces->code,
            'secondRace' => $item->secondRaces->code,
            'mapName' => $item->maps->name,
            'mapUrl' => $item->maps->url,
            'replayTitle' => $item->title,
            'replayRait' => $item->positive_count - $item->negative_count,
            'firstName' => $item->first_name,
            'secondName' => $item->second_name,
            'type' => $item->types->name,
        ];
    }


}
