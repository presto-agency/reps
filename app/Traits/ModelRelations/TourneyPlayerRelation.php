<?php

namespace App\Traits\ModelRelations;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait TourneyPlayerRelation
{

    /**
     * @return BelongsTo
     */
    //    public function file()
    //    {
    //        return $this->belongsTo('App\Models\File', 'file_id');
    //    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
