<?php

namespace App\Http\Controllers;

use App\Models\ForumTopic;
use App\Models\Replay;

class SearchController extends Controller
{

    public function index()
    {
        return view('search.index',
            [
                'searchData' => request('search'),
                'searchResult' => $this->searchResult(),
                'visible_title' => false,
            ]
        );
    }

    private function searchResult()
    {
        $searchResult['Replay'] = $dataReplay = Replay::where('title', 'like', '%' . request('search') . '%')->get();
        $searchResult['ForumTopic'] = $dataTopics = ForumTopic::where('title', 'like', '%' . request('search') . '%')->get();

        return $searchResult;

    }


}
