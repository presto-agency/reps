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

    /*$user->picture*/
    public function getPictureAttribute($value)
    {
        if (!empty($value) && \File::exists($value)) {
            return asset($value);
        } else {
            return asset('images/default/gallery/no-img.png');
        }
    }
    public function getTitle()
    {
        return $this->sign ? : null;
    }
}
