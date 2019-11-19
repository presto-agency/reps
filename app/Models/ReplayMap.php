<?php

namespace App\Models;

use App\Services\ServiceAssistants\PathHelper;
use Illuminate\Database\Eloquent\Model;

class ReplayMap extends Model
{
    protected $fillable = [
        'name',
        'url'
    ];

    /*$replayMap->url*/
    public function getUrlAttribute($value)
    {
        if (!empty($value)) {
            if (PathHelper::checkStorageFileExists(asset($value))) {
                return asset($value);
            }
            return asset('images/default/map/nominimap.png');
        }
        return asset('images/default/map/nominimap.png');

    }
}
