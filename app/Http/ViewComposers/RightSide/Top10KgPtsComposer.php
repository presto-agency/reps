<?php


namespace App\Http\ViewComposers\RightSide;


use App\User;
use Illuminate\View\View;

class Top10KgPtsComposer
{

    private $ttl = 300;// 5 mints

    private $topUserRating;
    private $topUserPoints;

    public function __construct()
    {
        $this->topUserRating = collect();
        $this->topUserPoints = collect();

        $topUserRating = $this->getCacheTopUserRating('top10Rating');
        $topUserPoints = $this->getCacheTopUserPoints('top10Points');

        $this->topUserRating = $topUserRating;
        $this->topUserPoints = $topUserPoints;
    }

    public function compose(View $view)
    {
        $view->with('top10Rating', $this->topUserRating);
        $view->with('top10Points', $this->topUserPoints);
    }


    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    private function getCacheTopUserRating(string $cache_name)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                return $this->getTopUserRating();
            });
        }

        return $data_cache;
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    private function getCacheTopUserPoints(string $cache_name)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                return $this->getTopUserPoints();
            });
        }

        return $data_cache;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getTopUserRating()
    {
        return User::with('countries:id,flag,name', 'races:id,title')
            ->where('rating', '>=', 0)
            ->orderByDesc('rating')
            ->limit(10)
            ->get(['id', 'name', 'rating', 'race_id', 'country_id']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getTopUserPoints()
    {
        return User::with('countries:id,flag,name', 'races:id,code,title')
            ->withCount('comments')
            ->orderByDesc('comments_count')
            ->limit(10)
            ->get();
    }

}
