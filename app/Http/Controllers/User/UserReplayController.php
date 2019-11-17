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
        $types = self::getCacheData('replayUserTypes', self::getTypes());
        $maps = self::getCacheData('replayUserMaps', self::getMaps());
        $countries = self::getCacheData('replayUserCountries', self::getCountries());
        $races = self::getCacheData('replayUserRaces', self::getRaces());

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

        return redirect()->route('user-replay.show', [
            'id'          => auth()->id(),
            'user_replay' => $data->id
        ]);
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
        return redirect()->to('/');
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
        $types = self::getCacheData('replayUserTypes', self::getTypes());
        $maps = self::getCacheData('replayUserMaps', self::getMaps());
        $countries = self::getCacheData('replayUserCountries', self::getCountries());
        $races = self::getCacheData('replayUserRaces', self::getRaces());

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

        return redirect()->route('user-replay.edit', [
            'id'          => auth()->id(),
            'user_replay' => $user_replay
        ]);

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
        $this->saveFile($request, $data);
    }

    private function replayDataUpdate($data, $request)
    {
        $data->user_replay = $request->user_replay;
        $this->columns($data, $request);
        $this->saveFile($request, $data);


    }

    public function columns($data, $request)
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
    }

    public function saveFile($request, $data)
    {
        // Check have input file
        if ($request->hasFile('file')) {
            // Check if upload file Successful Uploads
            if ($request->file('file')->isValid()) {
                // Check path
                PathHelper::checkUploadStoragePath("/files/replays");
                // Check old file
                PathHelper::checkFileAndDelete($data->file);
                // Upload file on server
                $image = $request->file('file');
                $filePath = $image->store('/files/replays', 'public');
                $data->file = 'storage/' . $filePath;
            } else {
                back();
            }
        }
    }

    private static function getRaces()
    {
        return Race::all([
            'id',
            'title'
        ]);
    }

    private static function getCountries()
    {
        return Country::all([
            'id',
            'name',
            'flag'
        ]);
    }

    private static function getTypes()
    {
        return ReplayType::all([
            'id',
            'name'
        ]);
    }

    private static function getMaps()
    {
        return ReplayMap::all([
            'id',
            'name',
            'url'
        ]);
    }

}
