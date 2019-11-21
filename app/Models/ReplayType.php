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
        return $this->hasMany(Replay::class, 'type_id', 'id');
    }

}
