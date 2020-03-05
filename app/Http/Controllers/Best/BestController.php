<?php

namespace App\Http\Controllers\Best;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class BestController extends Controller
{

    private $ttl = 300;//5 mints;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $points = $this->getCachePoints('top100UserPoints');
        $rating = $this->getCacheRating('top100UserRating');
        $news   = $this->getCacheNews('top100UserNews');
        $replay = $this->getCacheReplay('top100UserReplay');
        $gas    = $this->getCacheGas('top100UserGas');

        return view('best.index', compact('points', 'rating', 'news', 'replay', 'gas'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTop100UserPoints()
    {
        return User::with('countries:id,flag,name', 'races:id,title')
            ->withCount('comments')
            ->orderByDesc('comments_count')
            ->limit(100)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTop100UserRating()
    {
        return User::with('countries:id,flag,name', 'races:id,title')
            ->where('rating', '>=', 0)
            ->orderByDesc('rating')
            ->limit(100)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTop100UserNews()
    {
        return User::with('countries:id,flag,name', 'races:id,title')
            ->withCount('news')
            ->orderByDesc('news_count')
            ->limit(100)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTop100UserReplay()
    {
        return User::with('countries:id,flag,name', 'races:id,title')
            ->withCount('replays')
            ->orderByDesc('replays_count')
            ->limit(100)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTop100UserGas()
    {
        return User::with('countries:id,flag,name', 'races:id,title')
            ->where('gas_balance', '>', 0)
            ->orderByDesc('gas_balance')
            ->limit(100)
            ->get();
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    public function getCachePoints(string $cache_name)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                return $this->getTop100UserPoints();
            });
        }

        return $data_cache;
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    public function getCacheRating(string $cache_name)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                return $this->getTop100UserRating();
            });
        }

        return $data_cache;
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    public function getCacheNews(string $cache_name)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                return $this->getTop100UserNews();
            });
        }

        return $data_cache;
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    public function getCacheReplay(string $cache_name)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                return $this->getTop100UserReplay();
            });
        }

        return $data_cache;
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    public function getCacheGas(string $cache_name)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                return $this->getTop100UserGas();
            });
        }

        return $data_cache;
    }

    public function create()
    {
        return abort(404);
    }

    public function store(Request $request)
    {
        return abort(404);
    }

    public function show($id)
    {
        return abort(404);
    }

    public function edit($id)
    {
        return abort(404);
    }

    public function update(Request $request, $id)
    {
        return abort(404);
    }

    public function destroy($id)
    {
        return abort(404);
    }

}
