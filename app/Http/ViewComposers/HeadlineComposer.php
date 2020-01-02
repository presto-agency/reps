<?php


namespace App\Http\ViewComposers;

use App\Models\Headline;
use Cache;
use Illuminate\View\View;

class HeadlineComposer
{

    private $ttl = 36000;//10 hours

    private $category;

    public function __construct()
    {
        $this->category = collect();

        $data = $this->getCacheHeadline('headlineData');

        $this->category = $data;

    }

    public function compose(View $view)
    {
        $view->with('headlineData', $this->category);
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    private function getCacheHeadline(string $cache_name)
    {
        if (Cache::has($cache_name) && Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = Cache::get($cache_name);
        } else {
            $data_cache = Cache::remember($cache_name, $this->ttl, function () {
                return $this->getHeadline();
            });
        }

        return $data_cache;
    }

    /**
     * @return mixed
     */
    private function getHeadline()
    {
        return Headline::all(['title']);
    }

}
