<?php


namespace App\Http\ViewComposers\Stream;

use App\Models\Stream;
use Cache;
use Illuminate\View\View;

class OnlineStreamListComposer
{

    private $ttl = 330;
    private $category;

    public function __construct()
    {
        $this->category = collect();

        $data = $this->getCacheStreams('streamList');

        $this->category = $data;
    }

    public function compose(View $view)
    {
        $view->with('streamList', $this->category);
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    private function getCacheStreams(string $cache_name)
    {
        if (Cache::has($cache_name) && Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = Cache::get($cache_name);
        } else {
            $data_cache = Cache::remember($cache_name, $this->ttl, function () {
                return $this->getStreams();
            });
        }

        return $data_cache;
    }

    /**
     * @return mixed
     */
    private function getStreams()
    {
        return Stream::with('races:id,title', 'countries:id,flag,name')
            ->orderByDesc('id')
            ->whereApproved(true)
            ->whereActive(true)
            ->get(['id', 'race_id', 'country_id', 'title', 'stream_url_iframe']);
    }

}
