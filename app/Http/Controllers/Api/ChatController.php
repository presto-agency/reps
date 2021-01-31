<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiGetChatResource;
use App\Models\PublicChat;

class ChatController extends Controller
{

    /**
     * GET
     *
     * @OA\GET(
     *     summary="INDEX",
     *     path=GET_CHAT_LAST,
     *     description="List of last 100 Chat messages<br>
     <a target='_blank' href='https://docs.google.com/document/d/10cmWwCM23RIVUMf50LHjomIti2TVwtujt9IZLKoeoQA'>Listen channel with echo</a>",
     *     tags={"Chat"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful request!",
     *     @OA\MediaType(
     *             mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ChatGlobalData",)
     *         )
     *     )
     * )
     */

    /**
     * @OA\Schema(
     *      schema="ChatGlobalData",
     *      type="object",
     *      allOf={
     *          @OA\Schema(
     *          @OA\Property(property="messages", type="array",@OA\Items(ref="#/components/schemas/LastChatMessagesData")),
     *                )
     *      }
     *  )
     */

    /**
     * @OA\Schema(
     *      schema="LastChatMessagesData",
     *      type="object",
     *      allOf={
     *          @OA\Schema(
     *          @OA\Property(property="id", type="int",example="1",),
     *          @OA\Property(property="userName", type="string",example="User",),
     *          @OA\Property(property="message", type="string",example="...message...",),
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
        return response()->json(['messages' => ApiGetChatResource::collection(PublicChat::getLast100Messages())], 200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }


}

