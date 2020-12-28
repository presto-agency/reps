<?php


namespace App\Http\Controllers;

use App\Models\Comment;

class QuoteController
{

    private static $routeWithQuote = [
        'news.show'         => 'news.show',
        'topic.show'        => 'topic.show',
        'user-gallery.show' => 'user-gallery.show',
        'galleries.show'    => 'galleries.show',
        'replay.show'       => 'replay.show',
    ];

    public static function getQuote()
    {
        $request = request();

        if ($request->ajax() && $request->headers->has('referer')) {
            $routName = app('router')->getRoutes()->match(app('request')->create(request()->headers->get('referer')))->getName();
            if (array_key_exists($routName, self::$routeWithQuote)) {
                $messageData = Comment::with('user:id,name')->select('id', 'user_id', 'content')->find((int) $request->id);
                if (!is_null($messageData)) {
                    $dataQuote
                        = '[quote]'
                        .'[url='.route('user_profile', ['id' => $messageData->user_id]).']'.$messageData->user->name.'[/url]'
                        .'[quote-shell]'
                        .$messageData->content
                        .'[/quote-shell]'
                        .'[/quote]';
                    return \Response::json(['quote' => $dataQuote,], 200);
                }
            }
        }

        return \Response::json(['message' => 'Ops you doing something wrong',], 400);
    }

}
