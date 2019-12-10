<?php


namespace App\Http\ViewComposers\LeftSide;

use App\Models\Country;
use App\Models\Race;
use App\Models\Replay;
use App\Models\ReplayMap;
use App\Models\ReplayType;
use Illuminate\View\View;


class SearchReplaysComposer
{
    private $country;
    private $race;
    private $map;
    private $type;
    private $type2;
    private static $ttl = 300;

    public function __construct()
    {
        $this->country = $this->getCacheCountry('searchCountry', Country::all(['id', 'name']));
        $this->race = $this->getCacheCountry('searchReplay', Race::all(['id', 'title']));
        $this->map = $this->getCacheCountry('searchMap', ReplayMap::all(['id', 'name']));
        $this->type = $this->getCacheCountry('searchType', ReplayType::all(['id', 'title','name']));
        $this->type2 = $this->getCacheCountry('searchType2', collect(Replay::$userReplaysType));
    }

    public function compose(View $view)
    {
        $view->with('searchCountry', $this->country);
        $view->with('searchRace', $this->race);
        $view->with('searchMap', $this->map);
        $view->with('searchType', $this->type);
        $view->with('searchType2', $this->type2);
    }

    private function getCacheCountry($cache_name, $cache_data)
    {
        if (\Cache::has($cache_name) && !\Cache::get($cache_name)->isEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, self::$ttl, function () use ($cache_data) {
                return $cache_data;
            });
        }
        return $data_cache;
    }
}
