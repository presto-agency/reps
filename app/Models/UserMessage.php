<?php

namespace App\Models;

use App\Traits\ModelRelations\UserMessageRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMessage extends Model
{
    use UserMessageRelation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'dialogue_id',
        'message',
        'is_read',
    ];

    /**
     * Save new message
     *
     * @param Request $request
     * @param $dialogue_id
     * @return mixed
     */
    public static function createMessage(Request $request, $dialogue_id)
    {
        return UserMessage::create([
            'user_id'       => Auth::id(),
            'dialogue_id'   => $dialogue_id,
            'message'       => $request->get('message'),
        ]);
    }
}
