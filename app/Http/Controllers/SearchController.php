<?php

namespace App\Http\Controllers;

use App\Models\ForumTopic;
use App\Models\Replay;

class SearchController extends Controller
{

    public function index()
    {
        return view('search.index', [
            'searchData' => $this->searchData(),
            'searchResult' => $this->searchResult(),
        ]);
    }

    private function searchData()
    {
        return request('search');
    }

    private function searchResult()
    {
        $searchResult['Replay'] = $dataReplay = Replay::where('title', 'like', '%' . $this->searchData() . '%')->get();
        $searchResult['ForumTopic'] = $dataTopics = ForumTopic::where('title', 'like', '%' . $this->searchData() . '%')->get();

        return $searchResult;

    }


}
