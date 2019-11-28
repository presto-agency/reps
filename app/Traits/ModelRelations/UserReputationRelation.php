<?php
/**
 * Created by PhpStorm.
 * User: MAX
 * Date: 18.11.2019
 * Time: 11:35
 */

namespace App\Traits\ModelRelations;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait UserReputationRelation
{

    /**
     * Relations. Reputations user sender
     *
     * @return BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id','id');
    }

    /**
     * Relations. Reputations user sender
     *
     * @return BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo('App\User', 'recipient_id','id');
    }

    /**
     * Relations. Reputations user sender
     *
     * @return BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo('App\Models\ForumTopic', 'object_id','id');
    }

    /**
     * Relations. Reputations user sender
     *
     * @return BelongsTo
     */
    public function replay()
    {
        return $this->belongsTo('App\Models\Replay', 'object_id','id');
    }

    /**
     * Relations. Reputations user sender
     *
     * @return BelongsTo
     */
    public function gallery()
    {
        return $this->belongsTo('App\Models\UserGallery', 'object_id','id');
    }

    /**
     * Relations. Reputations user sender
     *
     * @return BelongsTo
     */
    public function commentRelation()
    {
        return $this->belongsTo('App\Models\Comment', 'object_id','id');
    }

}
