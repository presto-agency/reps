<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Replay\ReplayController;
use App\Http\Requests\UserReplayRequest;
use App\Services\ServiceAssistants\PathHelper;
use App\Models\{Replay, ReplayMap, Country, Race, ReplayType};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserReplayController extends Controller
{
    private static $ttl = 300;
    private static $USER_REPLAY = 'user-replay';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $relations = [
            'users:id,name,avatar',
            'maps:id,name',
            'firstCountries:id,flag,name',
            'secondCountries:id,flag,name',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',
        ];

        $replay = ReplayController::findUserReplays($relations, auth()->id());

        $proRout = self::$USER_REPLAY;
        return view('user.replay.index', compact('proRout', 'replay'));
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

        $this->replayDataSave($request);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $replay = ReplayController::findReplay($relations, $id);
        $countUserPts = $replay->users->totalComments->count();

        $proRout = self::$USER_REPLAY;

        $proRoutType = false;

        return view('user.replay.show',
            compact('replay', 'countUserPts', 'proRout', 'proRoutType')
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
        //
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
        //
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
        $data->user_replay = $request->user_replay;
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

    }
}
