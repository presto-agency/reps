<?php

namespace App\Traits\ModelRelations;


trait UserGalleryRelationTrait
{

    public function users()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }


}
