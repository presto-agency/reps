<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReplayType extends Model
{

    public function replays()
    {
        return $this->hasMany(\App\Models\Replay::class,'type_id','id');
    }
}
