<?php

namespace App\Traits\ModelRelations;


trait TourneyPlayerRelation
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
//    public function file()
//    {
//        return $this->belongsTo('App\Models\File', 'file_id');
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
