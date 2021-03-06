<?php

/**
 * streams settings
 */
return [

    "twitch" => [
        "host_i"        => "player.twitch.tv",
        "host"          => env("TWITCH_HOST", "www.twitch.tv"),
        "client_id"     => env("TWITCH_CLIENT_ID"),
        "client_secret" => env("TWITCH_CLIENT_SECRET"),
    ],

    "goodgame"  => [
        "host"     => env("GOODGAME_HOST", "goodgame.ru"),
        "base_uri" => env("GOODGAME_BASE_URI", "http://api2.goodgame.ru/"),
    ],
    "afreecatv" => [
        "host"     => env("AFREECATV_HOST", "play.afreecatv.com"),
        "base_uri" => env("AFREECATV_BASE_URI", "https://live.afreecatv.com/afreeca/"),
    ],
    'status'    => "live",

    'watcher' => [
        'endpoints' => [
            'defiler' => 'https://api.defiler.ru/api/v0/observer/online'
        ]
    ]
];
