<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dialogue extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'dialogue_user', 'dialogue_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany('App\Models\UserMessage','dialogue_id');
    }

    /**
     * Get User Dialog content
     *
     * @param $dialog_id
     * @return mixed
     */
    public static function getUserDialogueContent($dialog_id)
    {
        $dialogues = Dialogue::find($dialog_id)->messages()->orderBy('created_at', 'asc')->with('sender')->get();
        $user_id = \Auth::id();
        Dialogue::find($dialog_id)->messages()->where('user_id','<>',$user_id)->update(['is_read'=>1]);
        return $dialogues;
    }
}
