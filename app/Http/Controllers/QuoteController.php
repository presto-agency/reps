<?php


namespace App\Http\Controllers;

use App\Models\Comment;

class QuoteController
{

    public static function getQuote()
    {
        $request = request();

        if ($request->ajax() && $request->headers->has('referer')) {
            $routName = app('router')->getRoutes()->match(app('request')->create(request()->headers->get('referer')))->getName();
            if ($routName === 'news.show' || $routName === 'topic.show' || $routName === 'user-gallery.show' || $routName === 'galleries.show') {
                $messageData = Comment::with('user:id,name')->select('id', 'user_id', 'content')->find((int) $request->id);
                if ( ! empty($messageData)) {
                    $dataQuote
                        = '[quote]'
                        .'[url='.route('user_profile', ['id' => $messageData->user_id]).']'.$messageData->user->name.'[/url]'
                        .'[quote-shell]'
                        .$messageData->content
                        .'[/quote-shell]'
                        .'[/quote]';

                    return \Response::json([
                        'quote' => $dataQuote,
                    ], 200);
                }
            }
        }

        return \Response::json([], 400);
    }

}
