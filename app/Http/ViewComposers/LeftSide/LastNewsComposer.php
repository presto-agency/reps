<?php


namespace App\Http\ViewComposers\LeftSide;

use App\Models\ForumTopic;
use Illuminate\View\View;


class LastNewsComposer
{

    public $ttl = 300;//5 mints
    private $category;

    public function __construct()
    {
        $this->category = collect();

        $data = $this->getCacheLastNews('lastNewsLeft');

        $this->category = $data;
    }


    /**
     * @param  View  $view
     */
    public function compose(View $view)
    {
        $view->with('lastNewsLeft', $this->category);
    }

    public function getCacheLastNews(string $cache_name)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                return $this->getLastNews();
            });
        }

        return $data_cache;
    }

    /**
     * @return mixed
     */
    private function getLastNews()
    {
        return ForumTopic::withCount('comments')
            ->whereNotNull('commented_at')
            ->orderByDesc('commented_at')
            ->where('news', true)
            //            ->where('approved', true)
            ->take(10)
            ->get(['id', 'title']);
    }

}
