<?php
/**
 * Created by PhpStorm.
 * User: MAX
 * Date: 14.11.2019
 * Time: 15:50
 */

namespace App\Traits\ModelRelations;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait UserMessageRelation
{

    /**
     * @return BelongsTo
     */
    public function dialogue()
    {
        return $this->belongsTo('App\Models\Dialogue', 'dialogue_id');
    }

    /**
     * @return BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
