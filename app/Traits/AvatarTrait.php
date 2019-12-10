<?php

namespace App\Traits;

use checkFile;

trait AvatarTrait
{

    /**
     * Avatar or default
     *
     * @return string
     */
    public function avatarOrDefault()
    {
        if ( ! empty($this->avatar)
            && checkFile::checkFileExists($this->avatar)
        ) {
            return $this->avatar;
        } else {
            return 'images/default/avatar/avatar.png';
        }
    }

}


