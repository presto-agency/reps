<?php


namespace App\Http\ViewComposers\LeftSide;


use App\Models\Replay;
use Illuminate\View\View;

class LastReplaysComposer
{

    public $ttl = 300;//5 mints

    private $proReplay;
    private $userReplay;


    public function __construct()
    {
        $this->proReplay  = collect();
        $this->userReplay = collect();

        $proReplay  = $this->getCacheProReplays('replaysProLsHome');
        $userReplay = $this->getCacheUserReplays('replaysUserLsHome');

        $this->proReplay  = $proReplay;
        $this->userReplay = $userReplay;
    }


    /**
     * @param  View  $view
     */
    public function compose(View $view)
    {
        $view->with('replaysProLsHome', $this->proReplay);
        $view->with('replaysUserLsHome', $this->userReplay);
    }


    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    public function getCacheProReplays(string $cache_name)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                return $this->getReplays(Replay::REPLAY_PRO, 4);
            });
        }

        return $data_cache;
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    public function getCacheUserReplays(string $cache_name)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                return $this->getReplays(Replay::REPLAY_USER, 8);
            });
        }

        return $data_cache;
    }

    /**
     * @param  int  $user_replay
     * @param  int  $take
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function getReplays(int $user_replay, int $take)
    {
        return Replay::with([
            'firstCountries:id,flag,name',
            'secondCountries:id,flag,name',
            'firstRaces:id,code,title',
            'secondRaces:id,code,title',
        ])->where('approved', true)
            ->where('user_replay', $user_replay)
            ->orderByDesc('id')
            ->take($take)
            ->get(['id', 'title', 'first_race', 'second_race', 'first_country_id', 'second_country_id',]);
    }


}
