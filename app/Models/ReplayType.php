<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class ReplayType extends Model
{

//    use HasEagerLimit;
    protected $fillable
        = [
            'name', 'title',
        ];

    public function replays()
    {
        return $this->hasMany(Replay::class, 'type_id', 'id')
            ->where('approved', 1)
            ->where('user_replay', Replay::REPLAY_PRO)
            ->orderByDesc('id')
//            ->take(3)
            ;
    }

}
