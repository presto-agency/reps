<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGallery extends Model
{
    protected $fillable = [
        'picture', 'user_id', 'sign', 'for_adults', 'negative_count',
        'positive_count', 'comment', 'rating', 'comments_count', 'reviews',
    ];

    public function users()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

}
