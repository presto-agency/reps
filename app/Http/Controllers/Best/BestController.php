<?php

namespace App\Http\Controllers\Best;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $checkProLS = true;

        $points = self::getCacheData('top100UserPoints', self::getTop100UserPoints());
        $rating = self::getCacheData('top100UserRating', self::getTop100UserRating());
        $news = self::getCacheData('top100UserNews', self::getTop100UserNews());
        $replay = self::getCacheData('top100UserReplay', self::getTop100UserReplay());

        return view('best.index',
            compact('checkProLS', 'points', 'rating', 'news', 'replay')
        );
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return redirect()->to('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        return redirect()->to('/');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return redirect()->to('/');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        return redirect()->to('/');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        return redirect()->to('/');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        return redirect()->to('/');

    }

    public static function getTop100UserPoints()
    {
        return User::with('countries:id,flag,name', 'races:id,title')
            ->withCount('comments')
            ->orderByDesc('comments_count')
            ->limit(100)
            ->get();
    }

    public static function getTop100UserRating()
    {
        return User::with('countries:id,flag,name', 'races:id,title')
            ->where('rating', '>=', 0)
            ->orderByDesc('rating')
            ->limit(100)
            ->get();
    }

    public static function getTop100UserNews()
    {
        return User::with('countries:id,flag,name', 'races:id,title')
            ->withCount('news')
            ->orderByDesc('news_count')
            ->limit(100)
            ->get();
    }

    public static function getTop100UserReplay()
    {
        return User::with('countries:id,flag,name', 'races:id,title')
            ->withCount('replays')
            ->orderByDesc('replays_count')
            ->limit(100)
            ->get();
    }

    /**
     * @param $cache_name
     * @param $data
     * @return mixed
     */
    public static function getCacheData($cache_name, $data)
    {
        if (\Cache::has($cache_name) && \Cache::get($cache_name)->isNotEmpty()) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, 300, function () use ($data) {
                return $data;
            });
        }
        return $data_cache;
    }
}
