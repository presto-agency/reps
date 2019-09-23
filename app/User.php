<?php

namespace App;

use App\Models\Country;
use App\Models\Race;
use App\Models\Role;
use App\Models\UserGallery;
use App\Models\UserActivityLog;
use App\Traits\GravatarTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, GravatarTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar', 'role_id', 'name', 'email', 'country_id', 'race_id',
        'rating', 'count_topic', 'count_replay', 'count_picture', 'count_comment',
        'email_verified_at',
        'ban', 'activity_at', 'birthday', 'count_negative', 'count_positive',
        'password', 'remember_token',
        'homepage', 'isq', 'skype', 'vk_link', 'fb_link',
        'last_ip', 'count_gosu_replay', 'count_comment_forum', 'count_comment_gallery', 'count_comment_replays',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // Relations
    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function countries()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function races()
    {
        return $this->belongsTo(Race::class, 'race_id', 'id');
    }

    public function galleries()
    {
        return $this->hasMany(UserGallery::class, 'user_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(UserActivityLog::class, 'user_id', 'id');
    }

    public function isAdmin()
    {
//        $roleSA = Role::where('name', 'super-admin')->select('id')->first();
//        $roleA = Role::where('name', 'admin')->select('id')->first();
        return $this->role_id == 1 || $this->role_id == 2;
    }


    //admin password
    public function setNewPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }


}
