<?php

namespace App\Http\Controllers\Replay;

use App\Http\Controllers\Controller;
use App\Models\Replay;

class ReplayController extends Controller
{

    public $replayPro;
    public $replayProType;
    public static $replayUser;

    public static $replayProDuel;
    public static $replayProPack;
    public static $replayProGotw;
    public static $replayProTeam;
    public static $select = 3;


    public function showUser()
    {
        $replay = self::$replayUser;
        $replayTypeName = 'Пользовательские';
        return view('replay.index',
            compact('replay','replayTypeName')
        );
    }

    public function showPro()
    {
        $replay = $this->replayPro;
        $replayTypeName = 'Профессиональные';
        return view('replay.index',
            compact('replay','replayTypeName')
        );
    }

    public function showType()
    {
        $replay = $this->replayProType;
        return view('replay.index',
            compact('replay')
        );
    }

    /**
     * ReplayController constructor.
     */
    public function __construct()
    {

        $dataPro = null;
        $dataUser = null;
        $dataProWithType = null;

        $dataProWithDuel = [];
        $dataProWithPack = [];
        $dataProWithGotw = [];
        $dataProWithTeam = [];

        $getData = $this->getReplays();

        if (!$getData->isEmpty()) {
            foreach ($getData as $item) {
                if ($item->user_replay == Replay::REPLAY_PRO) {
                    $dataPro[] = self::getData($item);
                    /*get Data with single type*/
                    if ($item->types->name == self::getUrl()->last()) {
                        $dataProWithType[] = $this->getData($item);
                    }
                    /*Sort data with type*/
                    $dataProWithDuel[] = $this->setReplayProDuel($item);
                    $dataProWithPack[] = $this->setReplayProPack($item);
                    $dataProWithGotw[] = $this->setReplayProGotw($item);
                    $dataProWithTeam[] = $this->setReplayProTeam($item);
                } else {
                    $dataUser[] = self::getData($item);
                }
            }
        }

        self::$replayProDuel = $dataProWithDuel;
        self::$replayProPack = $dataProWithPack;
        self::$replayProGotw = $dataProWithGotw;
        self::$replayProTeam = $dataProWithTeam;

        $this->replayPro = $dataPro;
        $this->replayProType = $dataProWithType;
        self::$replayUser = $dataUser;
    }

    public function getReplays()
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
        $columns = [
            'user_id',
            'map_id',
            'type_id',
            'first_country_id',
            'second_country_id',
            'first_race',
            'second_race',

            'user_replay',
            'created_at',
            'title',
            'positive_count',
            'negative_count',
            'first_name',
            'second_name',
        ];
        return Replay::with($relation)
            ->where('approved', 1)
            ->orderByDesc('created_at')
            ->get($columns);
    }

    public static function getUrl()
    {
        return collect(request()->segments());
    }

    public static function checkUrlTournament()
    {
        return \Str::contains(self::getUrl(), 'tournament');
    }

    public static function checkUrlPro()
    {
        return \Str::contains(self::getUrl(), 'pro');
    }

    public static function getReplayUser()
    {
        return array_slice(array_filter(self::$replayUser), 0, self::$select);
    }


    public function setReplayProDuel($item)
    {
        if ($item->types->name == 'duel') {
            return self::getData($item);
        }
    }

    public function setReplayProPack($item)
    {
        if ($item->types->name == 'pack') {
            return self::getData($item);
        }
    }

    public function setReplayProGotw($item)
    {
        if ($item->types->name == 'gotw') {
            return self::getData($item);
        }
    }

    public function setReplayProTeam($item)
    {
        if ($item->types->name == 'team') {
            return self::getData($item);
        }
    }

    /**
     * @return 0|array
     */
    public static function getReplayProDuel()
    {
        if (self::checkUrlTournament() === false) {
            return array_slice(array_filter(self::$replayProDuel), 0, self::$select);
        } else {
            return [];
        }
    }

    /**
     * For min Queries
     * @return array
     */
    public static function getReplayProPack()
    {
        if (self::checkUrlTournament() === false) {
            return array_slice(array_filter(self::$replayProPack), 0, self::$select);
        } else {
            return [];
        }
    }

    /**
     * For min Queries
     * @return array
     */
    public static function getReplayProGotw()
    {
        if (self::checkUrlTournament() === false) {
            return array_slice(array_filter(self::$replayProGotw), 0, self::$select);
        } else {
            return [];
        }
    }

    /**
     * For min Queries
     * @return array
     */
    public static function getReplayProTeam()
    {
        if (self::checkUrlTournament() === false) {
            return array_slice(array_filter(self::$replayProTeam), 0, self::$select);
        } else {
            return [];
        }
    }

    /**
     * @param $item
     * @return array
     */
    public static function getData($item)
    {
        return [
            'userAvatar' => self::checkAvatar($item),
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

    /**
     * @param $item
     * @return mixed
     */
    public static function checkAvatar($item)
    {
        return file_exists($item->users->avatar) === true ? $item->users->avatar : $item->users->avatar_url_or_blank;
    }
}
