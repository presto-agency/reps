<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Replay\ReplayHelper;
use App\Http\Requests\UserReplayRequest;
use App\Services\ServiceAssistants\PathHelper;
use App\User;
use foo\bar;
use App\Models\{Replay, ReplayMap, Country, Race, ReplayType};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserReplayController extends Controller
{
    private static $ttl = 300;

    /**
     * Display a listing of the resource.
     *
     *
     * @param $id
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id, $type = null)
    {

        User::findOrFail($id);
        $relations = [
            'users:id,name,avatar',
            'maps:id,name',
            'firstCountries:id,flag,name',
            'secondCountries:id,flag,name',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',
        ];

        $type = ReplayHelper::getReplayType();

        $replay = ReplayHelper::findUserReplaysWithType2($relations, $id, $type);
        $type = $type == Replay::REPLAY_USER ? 'user' : 'pro';
        $userReplayRout = ReplayHelper::checkUrl() === true ? true : false;
        return view('user.replay.index', compact('replay', 'type', 'userReplayRout'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userReplay = Replay::$userReplaysType;
        $types = self::getCacheTypes('replayUserTypes');
        $maps = self::getCacheMaps('replayUserMaps');
        $countries = self::getCacheCountries('replayUserCountries');
        $races = self::getCacheRaces('replayUserRaces');

        return view('user.replay.create',
            compact('types', 'maps', 'countries', 'races', 'userReplay')
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param UserReplayRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserReplayRequest $request)
    {
        $replay = $this->replayDataSave($request);

        return redirect()->route('user-replay.show', ['id' => auth()->id(), 'user_replay' => $replay]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param int $user_replay
     * @param int $type
     * @return \Illuminate\Http\Response
     */
    public function show($id, $user_replay, $type = null)
    {
        $relations = [
            'users:id,name,avatar,count_positive,count_negative',
            'users.totalComments',
            'maps:id,name,url',
            'types:id,name,title',
            'firstCountries:id,flag,name',
            'secondCountries:id,flag,name',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',
            'comments',
        ];

        $type = ReplayHelper::getReplayType();

        $replay = ReplayHelper::findUserReplayWithType2($relations, $id, $user_replay, $type);

        $countUserPts = $replay->users->totalComments->count();

        $userReplayRout = ReplayHelper::checkUrl() === true ? true : false;

        $type = $type == Replay::REPLAY_USER ? 'user' : 'pro';

        return view('user.replay.show',
            compact('replay', 'countUserPts', 'type', 'userReplayRout')
        );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return back();
    }


    public static function getCacheRaces($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self::getRaces();
            });
        }
        return $data_cache;
    }

    public static function getCacheCountries($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self::getCountries();
            });
        }
        return $data_cache;
    }

    public static function getCacheTypes($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self::getTypes();
            });
        }
        return $data_cache;
    }

    public static function getCacheMaps($cache_name)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () {
                return self::getMaps();
            });
        }
        return $data_cache;
    }


    private static function getRaces()
    {
        return Race::all(['id', 'title']);
    }

    private static function getCountries()
    {
        return Country::all(['id', 'name', 'flag']);
    }

    private static function getTypes()
    {
        return ReplayType::all(['id', 'name']);
    }

    private static function getMaps()
    {
        return ReplayMap::all(['id', 'name', 'url']);
    }

    public function replayDataSave($request)
    {

        $data = new Replay;
        $data->user_id = auth()->id();
        $data->title = $request->title;
        $data->map_id = $request->map_id;
        $data->first_country_id = $request->first_country_id;
        $data->second_country_id = $request->second_country_id;
        $data->first_race = $request->first_race;
        $data->second_race = $request->second_race;
        $data->type_id = $request->type_id;
        $data->user_replay = Replay::REPLAY_USER;
        $data->first_location = $request->first_location;
        $data->second_location = $request->second_location;
        $data->content = $request->content;
        // Check have upload file
        if ($request->hasFile('file')) {
            // Check if upload file Successful Uploads
            if ($request->file('file')->isValid()) {
                // Check path
                PathHelper::checkUploadStoragePath("file/replay");
                // Upload file on server
                $image = $request->file('file');
                $filePath = $image->store('file/replay', 'public');
                $data->file = 'storage/' . $filePath;
            } else {
                back();
            }
        } else {
            back();
        }

        $data->save();
        return $data->id;
    }
}
