<?php

namespace App\Models;

use App\Traits\ModelRelations\UserGalleryRelationTrait;
use Illuminate\Database\Eloquent\Model;

class UserGallery extends Model
{
    use UserGalleryRelationTrait;

    protected $fillable = [
        'picture', 'user_id', 'sign', 'for_adults', 'negative_count',
        'positive_count', 'comment', 'rating', 'comments_count', 'reviews',
    ];

    public function setUserIdAttribute($value)
    {
        if ($value) {
            if (auth()->user()->id == $value) {
                $this->attributes['user_id'] = $value;
            }
        }
    }
}
