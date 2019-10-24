<?php


namespace App\Http\ViewComposers;


use App\Models\Replay;


class GetAllReplay
{
    public static $replayPro;
    public static $replayUser;

    public static $replay4User;
    public static $replay8Pro;

    public function __construct()
    {
        self::$replayPro = collect();
        self::$replayUser = collect();

        self::$replay4User = collect();
        self::$replay8Pro = collect();

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

        self::$replay4User = array_slice($dataPro, 0, 4);
        self::$replay8Pro = array_slice($dataUser, 0, 8);
    }


    public function getReplayPro()
    {
        return self::$replayPro;
    }

    public function getReplayUser()
    {
        return self::$replayUser;
    }

    public function get4ReplayUser()
    {
        return self::$replay4User;
    }

    public function get8ReplayPro()
    {
        return self::$replay8Pro;
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
        ];
    }


}
