<?php

namespace App\Models;

use App\Traits\ModelRelations\UserGalleryRelationTrait;
use checkFile;
use Illuminate\Database\Eloquent\Model;

class UserGallery extends Model
{

    use UserGalleryRelationTrait;

    protected $fillable
        = [
            'picture',
            'user_id',
            'sign',
            'for_adults',
            'negative_count',
            'positive_count',
            'comment',
            'rating',
            'comments_count',
            'reviews',
        ];

    /*$user->picture*/
    public function pictureOrDefault()
    {
        if ( ! empty($this->picture)
            && checkFile::checkFileExists($this->picture)
        ) {
            return $this->picture;
        } else {
            return 'images/default/gallery/no-img.png';
        }
    }


    public function getTitle()
    {
        return $this->sign ?: null;
    }

}
