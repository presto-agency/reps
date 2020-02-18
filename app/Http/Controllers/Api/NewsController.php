<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetLastNewsRequest;
use App\Http\Resources\ApiGetNewsResource;
use App\Models\ForumTopic;
use Illuminate\Http\Request;

class NewsController extends Controller
{


    public function index()
    {
        return \Response::json([], 200);
    }


    public function store(Request $request)
    {
        return \Response::json([], 200);
    }


    public function show($id)
    {
        return \Response::json([], 200);
    }


    public function update(Request $request, $id)
    {
        return \Response::json([], 200);
    }


    public function destroy($id)
    {
        return \Response::json([], 200);
    }


    public function last(GetLastNewsRequest $request)
    {
        $response = ApiGetNewsResource::collection($this->getNews());

        return \Response::json($response, 200);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getNews()
    {
        return ForumTopic::query()->latest()
            ->select(['id', 'title', 'rating', 'reviews', 'content', 'preview_img', 'preview_content'])
            ->where('hide', false)
            ->where('news', true)
            ->withCount('comments')
            ->limit(10)
            ->get();
    }

}
