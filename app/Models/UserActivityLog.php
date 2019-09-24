<?php

namespace App\Models;


use App\Traits\ModelRelations\UserActivityLogRelationTrait;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    use UserActivityLogRelationTrait;

    protected $fillable = [
        'type_id', 'user_id', 'time', 'ip', 'parameters'
    ];


}
