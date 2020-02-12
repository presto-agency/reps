<?php
/**
 * streams settings
 */
return [

    "twitch" => [
        "host" => env("TWITCH_HOST", "www.twitch.tv"),
        "base_uri" => env("TWITCH_BASE_URI", "https://api.twitch.tv/kraken/"),
        "client_id" => env("TWITCH_CLIENT_ID"),
    ],

    "goodgame" => [
        "host" => env("GOODGAME_HOST", "goodgame.ru"),
        "base_uri" => env("GOODGAME_BASE_URI", "http://api2.goodgame.ru/"),
    ],
    "afreecatv" => [
        "host" => env("AFREECATV_HOST", "play.afreecatv.com"),
        "base_uri" => env("AFREECATV_BASE_URI", "https://live.afreecatv.com/afreeca/"),
    ],
    'status' => 'live',
];
