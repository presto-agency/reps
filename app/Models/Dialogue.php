<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
     * Get User Dialog content
     *
     * @param $dialog_id
     *
     * @return mixed
     */
    public static function getUserDialogueContent($dialog_id)
    {
        $dialogues = Dialogue::find($dialog_id)->messages()
            ->orderBy('created_at', 'desc')->with('sender')->paginate(10);
        $user_id   = Auth::id();
        Dialogue::find($dialog_id)->messages()->where('user_id', '<>', $user_id)
            ->update(['is_read' => 1]);

        return $dialogues;
    }

    /**
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'dialogue_user', 'dialogue_id',
            'user_id');
    }

    /**
     * @return HasMany
     */
    public function messages()
    {
        return $this->hasMany('App\Models\UserMessage', 'dialogue_id');
    }

}
