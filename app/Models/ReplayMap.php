<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReplayMap extends Model
{

    protected $fillable = [
        'name',
        'url'
    ];

    public function defaultMap()
    {
        return 'images/default/map/nominimap.png';
    }
}
