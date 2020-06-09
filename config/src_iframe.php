<?php

return [
    'hosts' => [
        'youtu.be',
        'www.twitch.tv',
    ],
    'embed' => [
        'youtu.be'      => 'https://www.youtube.com/embed',
        'www.twitch.tv' => [
            'video' => 'https://player.twitch.tv/?autoplay=false&video=v',
            'clip'  => 'https://clips.twitch.tv/embed?clip=',
        ],
    ],

];
