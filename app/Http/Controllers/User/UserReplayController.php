<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Replay\ReplayHelper;
use App\Http\Requests\ReplayStoreRequest;
use App\Http\Requests\ReplayUpdateRequest;
use App\Services\ServiceAssistants\PathHelper;
use App\User;
use App\Models\{Replay, ReplayMap, Country, Race, ReplayType};

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
    public function index($id, $type = '')
    {

        User::findOrFail($id);

        $type = ReplayHelper::getReplayType() == Replay::REPLAY_USER ? 'user' : 'pro';
        $userReplayRout = ReplayHelper::checkUrl() === true ? true : false;
        $user_id = $id;
        $visible_title = false;

        return view('user.replay.index',
            compact('type', 'user_id', 'userReplayRout', 'visible_title')
        );

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
     * @param ReplayStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReplayStoreRequest $request)
    {
        $data = new Replay;
        $this->replayDataSave($data, $request);
        $data->save();

        return redirect()->route('user-replay.show', ['id' => auth()->id(), 'user_replay' => $data->id]);
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
     * @param int $user_replay
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $user_replay)
    {
        if ((auth()->user() != null && auth()->user()->role_id != 4) === false) {
            return redirect()->to('/');
        }
        $replay = Replay::findOrfail($user_replay);
        $userReplay = Replay::$userReplaysType;
        $types = self::getCacheData('replayUserTypes', self::getRaces());
        $maps = self::getCacheData('replayUserMaps', self::getCountries());
        $countries = self::getCacheData('replayUserCountries', self::getTypes());
        $races = self::getCacheData('replayUserRaces', self::getMaps());

        return view('user.replay.edit',
            compact('types', 'maps', 'countries', 'races', 'userReplay', 'replay')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ReplayUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ReplayUpdateRequest $request, $id, $user_replay)
    {
        $data = Replay::find($user_replay);
        $this->replayDataUpdate($data, $request);
        $data->save();

        return redirect()->route('user-replay.edit', ['id' => auth()->id(), 'user_replay' => $user_replay]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->to('/');
    }

    public function loadReplay()
    {
        $relations = [
            'users:id,name,avatar',
            'maps:id,name',
            'firstCountries:id,flag,name',
            'secondCountries:id,flag,name',
            'firstRaces:id,title,code',
            'secondRaces:id,title,code',
        ];
        if (request()->ajax()) {
            $visible_title = false;
            $user_id = request('user_id');
            $type = ReplayHelper::getReplayType();

            if (request('id') > 0) {
                $replay = self::getUserReplayAjaxId($relations, $type, request('id'), request('user_id'));

            } else {
                $replay = self::getUserReplayAjax($relations, $type, request('user_id'));
                $visible_title = true;
            }
            $type = $type == Replay::REPLAY_USER ? 'user' : 'pro';
            $userReplayRout = ReplayHelper::checkUrl() === true ? true : false;
            $output = view('user.replay.components.index',
                compact('replay', 'visible_title', 'type', 'user_id', 'userReplayRout')
            );
            echo $output;
        }
    }


    public static function getUserReplayAjaxId($relations, $user_replay, $id, $user_id)
    {
        return Replay::with($relations)
            ->orderByDesc('id')
            ->withCount('comments')
            ->where('user_id', $user_id)
            ->where('user_replay', $user_replay)
            ->where('id', '<', $id)
            ->limit(5)
            ->get();
    }

    public static function getUserReplayAjax($relations, $user_replay, $user_id)
    {
        return Replay::with($relations)
            ->orderByDesc('id')
            ->withCount('comments')
            ->where('user_id', $user_id)
            ->where('user_replay', $user_replay)
            ->limit(5)
            ->get();
    }


    public static function getCacheData($cache_name, $data)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () use ($data) {
                return $data;
            });
        }
        return $data_cache;
    }

    private function replayDataSave($data, $request)
    {
        $data->user_id = auth()->id();
        $data->user_replay = Replay::REPLAY_USER;

        $this->columns($data, $request);

//        $data->title = $request->title;
//        $data->map_id = $request->map_id;
//        $data->first_country_id = $request->first_country_id;
//        $data->second_country_id = $request->second_country_id;
//        $data->first_race = $request->first_race;
//        $data->second_race = $request->second_race;
//        $data->type_id = $request->type_id;
//        $data->first_location = $request->first_location;
//        $data->second_location = $request->second_location;
//        $data->content = $request->content;
//        $data->video_iframe = $request->video_iframe;
//        // Check have input file
//        if ($request->hasFile('file')) {
//            // Check if upload file Successful Uploads
//            if ($request->file('file')->isValid()) {
//                // Check path
//                PathHelper::checkUploadStoragePath("file/replay");
//                // Upload file on server
//                $image = $request->file('file');
//                $filePath = $image->store('file/replay', 'public');
//                $data->file = 'storage/' . $filePath;
//            } else {
//                back();
//            }
//        }
//        return $data;
    }

    private function replayDataUpdate($data, $request)
    {
        $data->user_replay = $request->user_replay;
        $this->columns($data, $request);

    }

    private function columns($data, $request)
    {
        $data->title = $request->title;
        $data->map_id = $request->map_id;
        $data->first_country_id = $request->first_country_id;
        $data->second_country_id = $request->second_country_id;
        $data->first_race = $request->first_race;
        $data->second_race = $request->second_race;
        $data->type_id = $request->type_id;
        $data->first_location = $request->first_location;
        $data->second_location = $request->second_location;
        $data->content = $request->content;
        $data->video_iframe = $request->video_iframe;
        // Check have input file
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
        }
        return $data;
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

}
