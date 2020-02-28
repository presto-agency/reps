<?php

return [
    'hosts' => [
        'www.youtube.com',
        'www.twitch.tv',
    ],
    'embed' => [
        'www.youtube.com' => 'https://www.youtube.com/embed/',
        'www.twitch.tv'   => [
            'video' => 'https://player.twitch.tv/?autoplay=false&video=v',
            'clip'  => 'https://clips.twitch.tv/embed?clip=',
        ],
    ],

];
