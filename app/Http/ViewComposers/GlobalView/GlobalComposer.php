<?php
/**
 * Created by PhpStorm.
 * User: MAX
 * Date: 23.10.2019
 * Time: 10:33
 */

namespace App\Http\ViewComposers\GlobalView;

use App\Models\Country;
use App\Models\Race;
use App\Models\Replay;
use App\Models\ReplayMap;
use App\Models\ReplayType;
use Illuminate\View\View;

class GlobalComposer
{

    private $ttl = 36000;//10 hours

    private $race;
    private $maps;
    private $countries;
    private $replayTypes;
    private $replayTypes2;

    public function __construct()
    {
        $this->race         = collect();
        $this->maps         = collect();
        $this->countries    = collect();
        $this->replayTypes  = collect();
        $this->replayTypes2 = collect();

        $race         = $this->getCacheRaces('race');
        $maps         = $this->getCacheMaps('maps');
        $countries    = $this->getCacheCountries('countries');
        $replayTypes  = $this->getCacheReplayTypes('replayTypes');
        $replayTypes2 = $this->getCacheReplayTypes2('replayTypes2');

        $this->race         = $race;
        $this->maps         = $maps;
        $this->countries    = $countries;
        $this->replayTypes  = $replayTypes;
        $this->replayTypes2 = $replayTypes2;
    }

    public function compose(View $view)
    {
        $view->with('race', $this->race);
        $view->with('maps', $this->maps);
        $view->with('countries', $this->countries);
        $view->with('replayTypes', $this->replayTypes);
        $view->with('replayTypes2', $this->replayTypes2);
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    public function getCacheRaces(string $cache_name)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                return Race::all(['id', 'title', 'code']);
            });
        }

        return $data_cache;
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    public function getCacheMaps(string $cache_name)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                return ReplayMap::all(['id', 'name', 'url']);
            });
        }

        return $data_cache;
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    public function getCacheCountries(string $cache_name)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                return Country::all(['id', 'name', 'code', 'flag']);
            });
        }

        return $data_cache;
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    public function getCacheReplayTypes(string $cache_name)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                return ReplayType::all(['id', 'name', 'title']);
            });
        }

        return $data_cache;
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    public function getCacheReplayTypes2(string $cache_name)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                return collect(Replay::$userReplaysType);
            });
        }

        return $data_cache;
    }


}

