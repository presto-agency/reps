<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    protected $fillable = [
        'user_id', 'title', 'race_id', 'content', 'country_id',
        'stream_url', 'approved'];

    public function users()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    public function races()
    {
        return $this->belongsTo(\App\Models\Race::class, 'race_id', 'id');
    }

    public function countries()
    {
        return $this->belongsTo(\App\Models\Country::class, 'country_id', 'id');
    }
}
