<?php

namespace App\Http\Controllers\Best;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class BestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkProLS = true;

        $points = $this->getPoints();
        $rating = $this->getRating();
        $news = $this->getNews();
        $replay = $this->getReplay();


        return view('best.index',
            compact('checkProLS', 'points', 'rating', 'news', 'replay')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->to('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->to('/');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->to('/');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->to('/');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return redirect()->to('/');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->to('/');

    }

    public function getPoints()
    {
        $getData = User::with('countries:id,flag,name', 'races:id,title')
            ->withCount('comments')
            ->orderByDesc('comments_count')
            ->limit(100)
            ->get();
        $data = null;
        if (!$getData->isEmpty()) {
            $data = $this->getDataArray($getData, 'comments');
        }
        return $data;
    }

    public function getRating()
    {
        $getData = User::with('countries:id,flag,name', 'races:id,title')
            ->orderByRaw("(count_positive - count_negative) DESC")
            ->whereRaw("(count_positive - count_negative) >= 0")
            ->limit(100)
            ->get();
        $data = null;
        if (!$getData->isEmpty()) {
            $data = $this->getDataArray($getData, 'rating');
        }
        return $data;
    }

    public function getNews()
    {
        $data = null;

        $getData = User::with('countries:id,flag,name', 'races:id,title')
            ->withCount('news')
            ->orderByDesc('total_news_count')
            ->limit(100)
            ->get();
        if (!$getData->isEmpty()) {
            $data = $this->getDataArray($getData, 'news');
        }

        return $data;
    }

    public function getReplay()
    {
        $getData = User::with('countries:id,flag,name', 'races:id,title')
            ->withCount('replays')
            ->orderByDesc('total_replays_count')
            ->limit(100)
            ->get();
        $data = null;
        if (!$getData->isEmpty()) {
            $data = $this->getDataArray($getData, 'replays');
        }

        return $data;
    }

    /**
     * @param $setData
     * @param $type
     * @return array
     */
    public function getDataArray($setData, $type)
    {
        $data = null;
        foreach ($setData as $item) {
            $data[] = [
                'id'               => $item->id,
                'name'             => $item->name,
                'avatar'           => $item->avatar,
                'raceIcon'         => "images/default/game-races/" . $item->races->title . ".png",
                'raceTitle'        => $item->races->title,
                'countryFlag25x20' => $item->countries->flag,
                'countryName'      => $item->countries->name,
                'max'              => $this->setMaxType($type, $item),
            ];
        }
        return $data;

    }

    /**
     * @param $type
     * @param $item
     * @return |null
     */
    public function setMaxType($type, $item)
    {
        switch ($type) {
            case 'comments':
                return $item->comments_count;
                break;
            case 'rating':
                return $item->count_positive - $item->count_negative;
                break;
            case 'news':
                return $item->total_news_count;
                break;
            case 'replays':
                return $item->total_replays_count;
                break;
            default:
                return null;
                break;
        }
    }
}
