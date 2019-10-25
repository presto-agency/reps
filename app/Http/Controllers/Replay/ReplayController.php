<?php

namespace App\Http\Controllers\Replay;

use App\Http\Controllers\Controller;
use App\Models\Replay;

class ReplayController extends Controller
{

    public $replayAll;
    public $replayPro;
    public $replayUser;

    public function showUser()
    {
        $replay = $this->getReplayUser();
        return view('replay.index',
            compact('replay')
        );
    }

    public function showPro()
    {
        $replay = $this->getReplayPro();
        return view('replay.index',
            compact( 'replay')
        );
    }

    /**
     * ReplayController constructor.
     */
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
        $this->replayPro = $dataPro;
        $this->replayUser = $dataUser;
        $this->replayAll = array_merge($dataPro, $dataUser);
    }

    /**
     * @return array
     */
    public function getReplayPro()
    {
        return $this->replayPro;
    }

    /**
     * @return array
     */
    public function getReplayUser()
    {
        return $this->replayUser;
    }

    /**
     * @return array
     */
    public function getAllReplay()
    {
        return $this->replayAll;
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
