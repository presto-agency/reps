<?php

namespace App\Models;

use App\Traits\ModelRelations\StreamRelationTrait;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use StreamRelationTrait;

    protected $fillable = [
        'user_id', 'title', 'race_id', 'content', 'country_id',
        'stream_url', 'approved'];


    public function setUserIdAttribute($value)
    {
        if ($value) {
            $this->attributes['user_id'] = auth()->user()->id;
        }
    }
}
