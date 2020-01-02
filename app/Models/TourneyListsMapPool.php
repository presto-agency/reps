<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourneyListsMapPool extends Model
{

    protected $guarded = ['tourney_id', 'map_id'];

    protected $casts
        = [
            'tourney_id' => 'integer',
            'map_id'     => 'integer',
        ];

    public function map()
    {
        return $this->belongsTo(ReplayMap::class, 'map_id', 'id');
    }

}
