<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiGetReplaysResource;
use App\Models\Replay;
use Illuminate\Http\Request;

class ReplaysController extends Controller
{

    /**
     * GET
     *
     * @OA\GET(
     *     summary="INDEX",
     *     path=GET_REPLAY_INDEX,
     *     description="Get replays this route have next param exemple:<br>/candidates?limit=0&offset=25&type=pro",
     *     tags={"Replays"},
     *       @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="`offset` exemple: `0`",
     *         @OA\Schema(
     *          type="integer",
     *          @OA\Property(property="offset"),
     *         ),
     *         style="form"
     *     ),
     *       @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="`limit` exemple: `10`",
     *         @OA\Schema(
     *          type="integer",
     *          @OA\Property(property="limit"),
     *         ),
     *         style="form"
     *     ),
     *      @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="Lis of types to `type by.` exemple: `pro`",
     *         @OA\Schema(
     *         type="array",
     *           @OA\Items(
     *               type="string",
     *               enum={"pro", "user", "all"},
     *           ),
     *         ),
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful request!",
     *     @OA\MediaType(
     *             mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ReplaysGlobalData",)
     *         )
     *     )
     * )
     */

    /**
     * @OA\Schema(
     *      schema="ReplaysGlobalData",
     *      type="object",
     *      allOf={
     *          @OA\Schema(
     *          @OA\Property(property="total", type="int",example="16025",),
     *          @OA\Property(property="replays", type="array",@OA\Items(ref="#/components/schemas/ReplayData")),
     *                )
     *      }
     *  )
     */

    /**
     * @OA\Schema(
     *      schema="ReplayData",
     *      type="object",
     *      allOf={
     *          @OA\Schema(
     *          @OA\Property(property="id", type="int",example="5",),
     *          @OA\Property(property="title", type="string",example="Jeez Weekly 100 (27.12.2020) full replay pack",),
     *          @OA\Property(property="firstCountry",type="string", example="Austria",),
     *          @OA\Property(property="secondCountry",type="string", example="African Rep.",),
     *          @OA\Property(property="firstRace",type="string", example="Zerg",),
     *          @OA\Property(property="secondRace",type="string", example="Terran",),
     *          @OA\Property(property="map", type="string", example="null",),
     *          @OA\Property(property="mapUrl", type="string", example="storage/images/replays/maps/c43c776d8bb43626270f7f6a0ae405a6.png",),
     *          @OA\Property(property="mapUrlFull", type="string", example="https://reps.ru/storage/images/replays/maps/c43c776d8bb43626270f7f6a0ae405a6.png",),
     *          @OA\Property(property="type", type="VOD",),
     *          @OA\Property(property="link", type="https://reps.ru/replay/5?type=pro",),
     *          @OA\Property(property="createdAt", type="timestamp",example="2020-12-21T14:55:14.000000Z",),
     *                )
     *      }
     *  )
     *
     *
     */

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $offset = $request->filled('offset') ? (int) $request->get('offset') : 0;
        $limit = $request->filled('limit') ? (int) $request->get('limit') : 10;


        $replays = Replay::ofUserReplay(self::getTypeId($request))
            ->with(['maps', 'firstCountries', 'secondCountries', 'firstRaces', 'secondRaces'])
            ->where('approved', 1)
            ->offset($offset)->limit($limit)
            ->get();

        return response()->json([
            'total'   => Replay::ofUserReplay(self::getTypeId($request))->where('approved', 1)->count(),
            'replays' => ApiGetReplaysResource::collection($replays),
        ], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private static function getTypeId(Request $request)
    {
        switch ($request->get('type')) {
            case  Replay::$type[Replay::REPLAY_PRO]:
                return Replay::REPLAY_PRO;
            case  Replay::$type[Replay::REPLAY_USER]:
                return Replay::REPLAY_USER;
            case 'all':
                return [Replay::REPLAY_PRO, Replay::REPLAY_USER];
            default :
                return null;
        }
    }

}
