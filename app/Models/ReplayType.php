<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReplayType extends Model
{

    protected $fillable
        = [
            'name', 'title',
        ];

    public function replays()
    {
        return $this->hasMany(Replay::class, 'type_id', 'id')
            ->orderByDesc('id')->where('approved', 1)
            ->where('user_replay', Replay::REPLAY_PRO)->withCount('comments');
    }

}
