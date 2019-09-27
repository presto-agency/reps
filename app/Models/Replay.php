<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelRelations\ReplayRelationTrait;

class Replay extends Model
{
    use ReplayRelationTrait;

    protected $fillable = [

        /*Show In Table*/

        'user_id',//Пользователь REPS.RU|StArSO
        'user_replay',//Название Shine_SouL 3 game
        'map_id',//Карта various
        'first_country_id', 'second_country_id',//Страны Korea (South) vs Korea (South)
        'first_race', 'second_race',//Расы T vs Z
        'type_id',// Gosu/Пользоватлеьский
        'comments_count', // Коментарии 11
        'user_rating', //Оценка пользователей
        'negative_count', 'rating', 'positive_count', //Рейтинг
        'approved',//Подтвержден

        /*Show In Edit/Create - Input*/

        //'user_replay',
        //'type_id',
        //'map_id',
        //'first_race',
        //'first_country_id',
        'first_location',
        'first_name',
        'first_apm',
        //'second_race',
        //'second_country_id',
        'second_location',
        'second_name',
        'second_apm',
        //'approved',
        'content',//Комментарий: + Подключить плагин для всех видео
        'downloaded',

        'start_date',// дата начала ?? чего?
        'file',//нужно пут к сохраненному файлу


//        'second_matchup',//???
//        'video_iframe',//ненужно

    ];

    protected $hidden = [
//        /*Hidden*/

////        'length',
////        'game_version_id',
////        'creating_rate',
////        'championship',
    ];

}
