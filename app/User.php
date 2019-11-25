<?php

namespace App;

use App\Traits\AvatarTrait;
use App\Traits\ModelRelations\UserRelation;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 *
 * @package App
 * @property  integer id
 * @property  string avatar
 * @mixin Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{

    use Notifiable, AvatarTrait, UserRelation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'avatar',
            'role_id',
            'name',
            'email',
            'country_id',
            'race_id',
            'rating',
            'email_verified_at',
            'ban',
            'activity_at',
            'birthday',
            'count_negative',
            'count_positive',
            'password',
            'remember_token',
            'homepage',
            'isq',
            'skype',
            'vk_link',
            'fb_link',
            'last_ip',
            'view_avatars',
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden
        = [
            'password',
            'remember_token',
        ];


    public function userViewAvatars()
    {
        if ($this->view_avatars == 1) {
            return true;
        }

        return false;
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'email_verified_at' => 'datetime',
        ];

    public function isAdmin()
    {
        return $this->roles->name == 'super-admin'
            || $this->roles->name == 'admin';
    }

    public function isNotUser()
    {
        return $this->roles->name != 'user' ? true : false;
    }

    public function isUser()
    {
        return $this->roles->name == 'user' ? true : false;
    }

    public function superAdminRole()
    {
        return $this->roles->name == 'super-admin' ? true : false;
    }

    public function adminRole()
    {
        return $this->roles->name == 'admin' ? true : false;
    }
    public function moderatorRole()
    {
        return $this->roles->name == 'moderator' ? true : false;
    }
    public function userRole()
    {
        return $this->roles->name == 'user' ? true : false;
    }
    /**
     * @param $id
     *
     * @return mixed
     */
    public static function getUserDataById($id)
    {
        return User::with('roles', 'countries', 'races')
            ->withCount('topics', 'comments', 'user_replay', 'gosu_replay')
            ->findOrFail($id);
    }

    public function isOnline()
    {
        if (is_null($this->activity_at)) {
            return false;
        }
        $time = Carbon::now()->diffInMinutes(Carbon::parse($this->activity_at));

        return $time <= 15;
    }

    /**
     * Gets from OLD reps.ru files
     *
     * @param $value
     *
     * @return string
     */
    public function getUserStatus($value)
    {
        if ($value < 1000) {
            return "Zim";
        } elseif ($value < 2000) {
            return "Fan of Barbie";
        } elseif ($value < 3000) {
            return "Zagoogli";
        } elseif ($value < 4000) {
            return "BIG SCV";
        } elseif ($value < 5000) {
            return "Hasu";
        } elseif ($value < 6000) {
            return "XaKaC";
        } elseif ($value < 7000) {
            return "Idra";
        } elseif ($value < 8000) {
            return "Trener";
        } elseif ($value < 9000) {
            return "[СО!]";
        } elseif ($value < 10000) {
            return "SuperHero";
        } elseif ($value < 15000) {
            return "Gosu";
        } elseif ($value < 20000) {
            return "IPXZerg";
        } elseif ($value < 40000) {
            return "Savior";
        } elseif ($value < 70000) {
            return "Lutshii";
        } elseif ($value < 100000) {
            return "Bonjva";
        } elseif ($value >= 100000) {
            return "Ebanutyi";
        }
    }

    public function checkUserLink($str)
    {
        if (preg_match('/^(http|https):\/\//i', $str)) {
            $url = $str;
        } else {
            $url = 'http://'.$str;
        }
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }

        return false;
    }

}
