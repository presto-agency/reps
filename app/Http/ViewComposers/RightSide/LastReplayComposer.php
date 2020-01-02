<?php


namespace App\Http\ViewComposers\RightSide;

use App\Models\Replay;
use Illuminate\View\View;


class LastReplayComposer
{

    private $ttl = 300;// 5 mints

    private $replays;

    public function __construct()
    {
        $this->replays = collect();

        $replays = $this->getCacheReplays('lastReplaysRight');

        $this->replays = $replays;
    }

    /**
     * @param  View  $view
     */
    public function compose(View $view)
    {
        $view->with('lastReplaysRight', $this->replays);
    }


    public function getCacheReplays(string $cache_name)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                return $this->getReplays();
            });
        }

        return $data_cache;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private static function getReplays()
    {
        return Replay::withCount('comments')
            ->where('user_replay', Replay::REPLAY_USER)
            ->where('approved', true)
            ->orderByDesc('id')
            ->limit(5)
            ->get();
    }

}
