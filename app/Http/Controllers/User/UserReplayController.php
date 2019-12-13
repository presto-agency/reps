<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Replay\ReplayHelper;
use App\Http\Requests\ReplayStoreRequest;
use App\Http\Requests\ReplayUpdateRequest;
use App\Models\{Country, Race, Replay, ReplayMap, ReplayType};
use App\Services\ServiceAssistants\PathHelper;
use App\User;
use Cohensive\Embed\Facades\Embed;

class UserReplayController extends Controller
{

    private static $ttl = 300;


    /**
     * Display a listing of the resource.
     *
     *
     * @param $id
     * @param $type
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id, $type = '')
    {
        User::findOrFail($id);

        $type = ReplayHelper::getReplayType() == Replay::REPLAY_USER ? 'user' : 'pro';

        $userReplayRout = ReplayHelper::checkUrl() === true ? true : false;
        $user_id        = $id;
        $visible_title  = false;

        return view('user.replay.index',
            compact('type', 'user_id', 'userReplayRout', 'visible_title')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        Replay::checkUser4Update();

        $userReplay = Replay::$userReplaysType;
        $types      = self::getCacheData('replayUserTypes', self::getTypes());
        $maps       = self::getCacheData('replayUserMaps', self::getMaps());
        $countries  = self::getCacheData('replayUserCountries', self::getCountries());
        $races      = self::getCacheData('replayUserRaces', self::getRaces());

        return view('user.replay.create',
            compact('types', 'maps', 'countries', 'races', 'userReplay')
        );
    }


    /**
     * @param  ReplayStoreRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ReplayStoreRequest $request)
    {
        $title      = clean($request->get('title'));
        $content    = clean($request->get('content'));
        $src_iframe = clean($request->get('src_iframe'));
        $file       = $request->file('file');
        if (empty($title)) {
            return back();
        }
        if (empty($content)) {
            return back();
        }
        if (empty($src_iframe) && empty($file)) {
            return back();
        }

        $data = new Replay;
        $this->replayDataSave($data, $request);
        $data->save();
        $type = Replay::$type;

        return redirect()->to(asset("replay/{$data->id}"."?type=".$type[$data->user_replay]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  int  $user_replay
     * @param  int  $type
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id, $user_replay, $type = null)
    {
        return redirect()->to('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  int  $user_replay
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function edit($id, $user_replay)
    {
        if ((auth()->user() != null && auth()->user()->role_id != 4) === false
        ) {
            return redirect()->to('/');
        }
        $replay     = Replay::findOrfail($user_replay);
        $userReplay = Replay::$userReplaysType;
        $types      = self::getCacheData('replayUserTypes', self::getTypes());
        $maps       = self::getCacheData('replayUserMaps', self::getMaps());
        $countries  = self::getCacheData('replayUserCountries', self::getCountries());
        $races      = self::getCacheData('replayUserRaces', self::getRaces());

        return view('user.replay.edit',
            compact('types', 'maps', 'countries', 'races', 'userReplay',
                'replay')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ReplayUpdateRequest  $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ReplayUpdateRequest $request, $id, $user_replay)
    {
        $title      = clean($request->get('title'));
        $content    = clean($request->get('content'));
        $src_iframe = clean($request->get('src_iframe'));
        $file       = $request->file('file');
        if (empty($title)) {
            return back();
        }
        if (empty($content)) {
            return back();
        }
        if (empty($src_iframe) && empty($file)) {
            return back();
        }
        if (empty($title) || empty($content) || empty($src_iframe)) {
            return back();
        }
        $data = Replay::find($user_replay);
        $this->replayDataUpdate($data, $request);
        $data->save();
        $type = Replay::$type;

        return redirect()->to(asset("replay/{$data->id}"."?type=".$type[$data->user_replay]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
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
            $user_id       = request('user_id');
            $type          = ReplayHelper::getReplayType();

            if (request('id') > 0) {
                $replay = self::getUserReplayAjaxId($relations, $type, request('id'), request('user_id'));
            } else {
                $replay        = self::getUserReplayAjax($relations, $type, request('user_id'));
                $visible_title = true;
            }
            $type           = $type == Replay::REPLAY_USER ? 'user' : 'pro';
            $userReplayRout = ReplayHelper::checkUrl() === true ? true : false;
            $output         = view('user.replay.components.index',
                compact('replay', 'visible_title', 'type', 'user_id',
                    'userReplayRout')
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

    private function replayDataSave($data, $request)
    {
        if (auth()->user()->roles->name == 'user') {
            $data->user_replay = Replay::REPLAY_USER;
        } else {
            $data->user_replay = $request->user_replay;
        }
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
        $data->title             = clean($request->title);
        $data->map_id            = $request->map_id;
        $data->first_country_id  = $request->first_country_id;
        $data->second_country_id = $request->second_country_id;
        $data->first_race        = $request->first_race;
        $data->second_race       = $request->second_race;
        $data->type_id           = $request->type_id;
        $data->first_location    = $request->first_location;
        $data->second_location   = $request->second_location;
        $data->content           = clean($request->content);
        $data->src_iframe        = clean($request->src_iframe);
    }

    public function iframe()
    {
        $request = request();
        if ($request->ajax()) {
            $embed = Embed::make($request->video_iframe_url)->parseUrl();
            if ($embed == false || empty($embed)) {
                return \Response::json([
                    'success' => 'false',
                    'message' => 'Указаный сервис не поддерживаеться',
                ], 400);
            }
            $embed->setAttribute([
                'width'  => '100%',
                'height' => '100%',
            ]);
            $iframe_string = $embed->getHtml();
            try {
                preg_match('/src="([^"]+)"/', $iframe_string, $match);
                $src = $match[1];
            } catch (\Exception $e) {
                \Log::error($e);
            }

            return \Response::json([
                'success' => 'true',
                'message' => $src,
            ], 200);
        }

        return null;
    }

    public function saveFile($request, $data)
    {
        // Check have input file
        if ($request->hasFile('file')) {
            // Check if upload file Successful Uploads
            if ($request->file('file')->isValid()) {
                // Check path
                PathHelper::checkUploadsFileAndPath("/files/replays");
                // Upload file on server
                $image    = $request->file('file');
                $filePath = $image->store('files/replays', 'public');

                $data->file = 'storage/'.$filePath;
            }
        }
    }

    public static function getCacheData($cache_name, $data)
    {
        if (\Cache::has($cache_name) && ! \Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () use ($data) {
                return $data;
            });
        }

        return $data_cache;
    }

    private static function getRaces()
    {
        return Race::all(['id', 'title',]);
    }

    private static function getCountries()
    {
        return Country::all(['id', 'name', 'flag',]);
    }

    private static function getTypes()
    {
        return ReplayType::all(['id', 'name',]);
    }

    private static function getMaps()
    {
        return ReplayMap::all(['id', 'name', 'url',]);
    }

}
