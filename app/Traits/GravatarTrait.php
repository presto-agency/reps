<?php

namespace App\Traits;

use App\Services\ServiceAssistants\PathHelper;


trait GravatarTrait
{
    /*$user->avatar*/
    public function getAvatarAttribute($value)
    {
        if (!empty($value)) {
            if (PathHelper::checkStorageFileExists(asset($value))) {
                return asset($value);
            }
            return asset('images/default/avatar/avatar.png');
        }
        return asset('images/default/avatar/avatar.png');
    }
}


