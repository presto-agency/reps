<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\ApiGetStreamsResource;
use App\Models\Stream;

class StreamController extends Controller
{

    /**
     * GET
     *
     * @OA\GET(
     *     summary="INDEX",
     *     path=GET_STREAM_ONLINE,
     *     description="List of approved & online streams",
     *     tags={"Stream"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful request!",
     *     @OA\MediaType(
     *             mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/StreamGlobalData",)
     *         )
     *     )
     * )
     */

    /**
     * @OA\Schema(
     *      schema="StreamGlobalData",
     *      type="object",
     *      allOf={
     *          @OA\Schema(
     *          @OA\Property(property="streams", type="array",@OA\Items(ref="#/components/schemas/StreamOnlineNewsData")),
     *                )
     *      }
     *  )
     */

    /**
     * @OA\Schema(
     *      schema="StreamOnlineNewsData",
     *      type="object",
     *      allOf={
     *          @OA\Schema(
     *          @OA\Property(property="id", type="int",example="12",),
     *          @OA\Property(property="race", type="string",example="Zerg",),
     *          @OA\Property(property="country", type="string",example="Korea (South)",),
     *          @OA\Property(property="title", type="string",example="ggaemo",),
     *          @OA\Property(property="content", type="string",example="Ex KT B-teamer",),
     *          @OA\Property(property="streamUrl", type="string",example="https://play.afreecatv.com/kkmkhh1234",),
     *          @OA\Property(property="streamUrlIframe", type="string",example="https://play.afreecatv.com/kkmkhh1234/embed",),
     *          @OA\Property(property="approved", type="bool",example="true",),
     *          @OA\Property(property="source", type="string",example="play.afreecatv.com",),
     *          @OA\Property(property="channel", type="string",example="kkmkhh1234",),
     *                )
     *      }
     *  )
     *
     *
     */

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function online()
    {

        $streams = Stream::with([
            'races',
            'countries'
        ])->where('approved', 1)
            ->whereNotNull('stream_url')
            ->where('stream_url', '!=', ' ')
            ->where('stream_url', '!=', '')
            ->where('active', 1)
            ->get();
        $data = ApiGetStreamsResource::collection($streams);
        return response()->json([
            'streams' => $data,
        ], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}


