<?php

namespace App\Http\Controllers\User;

use App\Models\{Replay, ReplayMap, Country, Race, ReplayType};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserReplayController extends Controller
{
    private static $ttl = 300;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        return view('user.replay.create', compact('types', 'maps', 'countries', 'races', 'userReplay'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
