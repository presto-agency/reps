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
     *     description="Get pro replays",
     *     tags={"Replays"},
     *       @OA\Parameter(
     *         name="skip",
     *         in="query",
     *         description="`skip` exemple: `0`",
     *         @OA\Schema(
     *          type="integer",
     *          @OA\Property(property="skip"),
     *         ),
     *         style="form"
     *     ),
     *       @OA\Parameter(
     *         name="take",
     *         in="query",
     *         description="`take` exemple: `10`; max:`100`",
     *         @OA\Schema(
     *          type="integer",
     *          @OA\Property(property="take"),
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
     *          @OA\Property(property="firstName",type="string", example="Y33PPP",),
     *          @OA\Property(property="secondName",type="string", example="94khala",),
     *          @OA\Property(property="map", type="string", example="null",),
     *          @OA\Property(property="mapUrl", type="string", example="storage/images/replays/maps/c43c776d8bb43626270f7f6a0ae405a6.png",),
     *          @OA\Property(property="mapUrlFull", type="string", example="https://reps.ru/storage/images/replays/maps/c43c776d8bb43626270f7f6a0ae405a6.png",),
     *          @OA\Property(property="type", type="string", example="VOD",),
     *          @OA\Property(property="status", type="string", example="Game of the Week",),
     *          @OA\Property(property="link", type="https://reps.ru/replay/5?type=pro",),
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
        $skip = $request->filled('skip') ? (int) $request->get('skip') : 0;
        $take = $request->filled('take') ? (int) $request->get('take') : 10;

        if ($take > 100) {
            $take = 100;
        }
        $replays = Replay::with(['maps', 'firstCountries', 'secondCountries', 'firstRaces', 'secondRaces', 'types'])
            ->where('user_replay', Replay::REPLAY_PRO)
            ->where('approved', 1)
            ->orderByDesc('id')
            ->skip($skip)->take($take)
            ->get();

        return response()->json([
            'total'   => Replay::query()->where('user_replay', Replay::REPLAY_PRO)->where('approved', 1)->count(),
            'replays' => ApiGetReplaysResource::collection($replays),
        ], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

}
