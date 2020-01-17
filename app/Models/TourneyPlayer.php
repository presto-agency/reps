<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TourneyPlayer extends Model
{


    protected $guarded
        = [
            'check',
            'ban',
            'description',
            'place_result',
            'tourney_id',
            'user_id',
        ];
    protected $casts
        = [
            'check'        => 'int',
            'ban'          => 'int',
            'description'  => 'string',
            'place_result' => 'int',
            'tourney_id'   => 'int',
            'user_id'      => 'int',
        ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function tourney()
    {
        return $this->belongsTo(TourneyList::class, 'tourney_id', 'id');
    }

}
