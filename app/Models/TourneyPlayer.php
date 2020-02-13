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
            'victory_points',
            'tourney_id',
            'user_id',
            'defeat',
        ];
    protected $casts
        = [
            'check'          => 'int',
            'ban'            => 'int',
            'description'    => 'string',
            'place_result'   => 'int',
            'victory_points' => 'int',
            'defeat'         => 'int',
            'tourney_id'     => 'int',
            'user_id'        => 'int',
        ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tourney()
    {
        return $this->belongsTo(TourneyList::class, 'tourney_id', 'id');
    }

}
