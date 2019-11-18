<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property integer $id
 * @property integer $object_id
 * @property integer $sender_id
 * @property integer $recipient_id
 * @property string $rating
 * @property integer $relation
 * @property string $comment
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class UserReputation extends Model
{
    use Notifiable, UserReputationRelation;

}
