<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelRelations\ReplayRelationTrait;

class Replay extends Model
{
    use ReplayRelationTrait;

    protected $fillable = [

        /*Show In Table*/
        'user_id',
        'user_replay',
        'map_id',
        'first_country_id', 'second_country_id',
        'first_race', 'second_race',
        'type_id',
        'comments_count',
        'user_rating',
        'negative_count', 'rating', 'positive_count',
        'approved',

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
        'content',
        'downloaded',

        'start_date',
        'file',

    ];


    public function setUserIdAttribute($value)
    {
        if ($value) {
            if (auth()->user()->id == $value) {
                $this->attributes['user_id'] = $value;
            }
            if (auth()->user()->id != $value) {
                die;
            }
        }
    }

}
