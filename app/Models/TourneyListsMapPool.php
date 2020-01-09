<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourneyListsMapPool extends Model
{

    protected $guarded = ['tourney_id', 'map_id'];

    protected $casts
        = [
            'tourney_id' => 'int',
            'map_id'     => 'int',
        ];

    public function map()
    {
        return $this->belongsTo(ReplayMap::class, 'map_id', 'id');
    }

}
