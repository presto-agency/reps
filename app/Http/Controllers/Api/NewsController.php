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
        $newsFix = self::getLastNews(false, true, true, 3);
        $newsNormal = self::getLastNews(false, false, true, 3);

        $newsAll = $newsFix->merge($newsNormal);

        $news = ApiGetNewsResource::collection($newsAll);

        return response()->json(['news' => $news,], 200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $hide
     * @param $fixing
     * @param $news
     * @param $extraLimit
     * @return \Illuminate\Support\Collection
     */
    public static function getLastNews($hide, $fixing, $news, $extraLimit)
    {
        $data = collect();
        $extra = 0;

        $item = ForumTopic::query()
            ->orderByDesc('id')
            ->where('hide', $hide)
            ->where('fixing', $fixing)
            ->where('news', $news)
            ->first();

        $lastId = $item->id;

        $data->push($item);

        do {
            $item = ForumTopic::query()
                ->orderByDesc('id')
                ->where('id', '<', $lastId)
                ->where('hide', $hide)
                ->where('fixing', $fixing)
                ->where('news', $news)
                ->first();

            if (!is_null($item)) {
                $lastId = $item->id;
                $data->push($item);
            }

            $extra++;
        } while ($extra <= $extraLimit);

        return $data;
    }

}

