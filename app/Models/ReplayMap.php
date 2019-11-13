<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReplayMap extends Model
{
    protected $fillable = ['name', 'url'];

    /*$replayMap->url*/
    public function getUrlAttribute($value)
    {
        if (!empty($value) && \File::exists($value)) {
            return asset($value);
        } else {
            return asset('images/default/map/nominimap.png');
        }
    }
}
