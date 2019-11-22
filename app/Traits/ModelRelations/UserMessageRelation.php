<?php
/**
 * Created by PhpStorm.
 * User: MAX
 * Date: 14.11.2019
 * Time: 15:50
 */

namespace App\Traits\ModelRelations;


trait UserMessageRelation
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dialogue()
    {
        return $this->belongsTo('App\Models\Dialogue', 'dialogue_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}