<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetLastNewsRequest;
use App\Http\Resources\ApiGetNewsResource;
use App\Models\ForumTopic;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return \Response::json([], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param  \App\Http\Requests\Api\GetLastNewsRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
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
            ->where('preview', false)
            ->where('news', true)
            ->withCount('comments')
            ->limit(10)
            ->get();
    }

}
