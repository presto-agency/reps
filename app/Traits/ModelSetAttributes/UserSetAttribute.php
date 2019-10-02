<?php

namespace App\Traits\ModelSetAttributes;


trait UserSetAttribute
{

    //admin password Mutator
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = \Hash::make($value);
        }
    }
}
