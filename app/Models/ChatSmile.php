<?php

namespace App\Models;

use App\User;
use checkFile;
use Illuminate\Database\Eloquent\Model;

class ChatSmile extends Model
{

    protected $fillable
        = [
            'user_id', 'image', 'comment', 'charactor',
        ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function imageOrDefault()
    {
        if ( ! empty($this->image)
            && checkFile::checkFileExists($this->image)
        ) {
            return $this->image;
        } else {
            return 'images/default/gallery/no-img.png';
        }
    }

}
