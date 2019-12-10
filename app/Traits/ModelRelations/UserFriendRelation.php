<?php
/**
 * Created by PhpStorm.
 * User: MAX
 * Date: 30.10.2019
 * Time: 17:06
 */

namespace App\Traits\ModelRelations;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait UserFriendRelation
{

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function friend_user()
    {
        return $this->belongsTo('App\User', 'friend_user_id');
    }

}
