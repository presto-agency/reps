<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiGetNewsResource;
use App\Models\ForumTopic;

class NewsController extends Controller
{

    /**
     * GET
     *
     * @OA\GET(
     *     summary="INDEX",
     *     path=GET_NEWS_LAST,
     *     description="List of last 10 News in BBCODE",
     *     tags={"News"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful request!",
     *     @OA\MediaType(
     *             mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/NewsGlobalData",)
     *         )
     *     )
     * )
     */

    /**
     * @OA\Schema(
     *      schema="NewsGlobalData",
     *      type="object",
     *      allOf={
     *          @OA\Schema(
     *          @OA\Property(property="news", type="array",@OA\Items(ref="#/components/schemas/LastNewsData")),
     *                )
     *      }
     *  )
     */

    /**
     * @OA\Schema(
     *      schema="LastNewsData",
     *      type="object",
     *      allOf={
     *          @OA\Schema(
     *          @OA\Property(property="id", type="int",example="42877",),
     *          @OA\Property(property="title", type="string",example="Defiler Tour #88 - Анонс!",),
     *          @OA\Property(property="content", type="string",example="...content...",),
     *          @OA\Property(property="previewImg", type="storage/images/topics/December2020/332746b6e02742c436ace3ca47800cf5.png",),
     *          @OA\Property(property="previewImgFull", type="https://reps.ru/storage/images/topics/December2020/332746b6e02742c436ace3ca47800cf5.png",),
     *          @OA\Property(property="previewContent", type="...previewContent...",),
     *          @OA\Property(property="createdAt", type="timestamp",example="2020-12-21T14:55:14.000000Z",),
     *                )
     *      }
     *  )
     *
     *
     */

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function last()
    {

        $news = ForumTopic::query()
            ->orderByDesc('id')
            ->where('hide', false)
            ->where('fixing', false)
            ->where('news', true)
            ->take(5)
            ->get();

        $fixNews = ForumTopic::query()
            ->orderByDesc('id')
            ->where('hide', 0)
            ->where('fixing', 1)
            ->where('news', 1)
            ->take(5)
            ->get();

        $merge = $fixNews->merge($news);

        return response()->json([
            'news' => ApiGetNewsResource::collection($merge),
        ], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }


}
