<?php

namespace App;

use App\Traits\GravatarTrait;
use App\Traits\ModelRelations\UserRelation;
use App\Traits\ModelSetAttributes\UserSetAttribute;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, GravatarTrait, UserRelation, UserSetAttribute;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar', 'role_id', 'name', 'email', 'country_id', 'race_id', 'rating',
        'count_topic', 'count_replay', 'count_picture', 'count_comment',
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

    public function isAdmin()
    {
        return $this->roles->name == 'super-admin' || $this->roles->name == 'admin';
    }

    public function hasSuperAdmin()
    {
        return $this->roles->name == 'super-admin' ? true : false;
    }

    public function superAdminRoles()
    {
        return $this->roles->name == 'super-admin' ? true : false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getUserDataById($id)
    {
        return User::where('id',$id)
            ->with('roles', 'countries', 'races')
            ->withCount( 'topics', 'comments', 'user_replay', 'gosu_replay')
//            ->withCount( 'positive', 'negative', 'comments')
//            ->withCount('user_galleries', 'topics', 'replay', 'gosu_replay', 'topic_comments', 'replay_comments', 'gallery_comments')
            ->first();
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
     */
    public function getUserStatus($cs)
    {
        if ($cs < 1000) {
            return "Zim";
        } elseif ($cs < 2000) {
            return "Fan of Barbie";
        } elseif ($cs < 3000) {
            return "Zagoogli";
        } elseif ($cs < 4000) {
            return "BIG SCV";
        } elseif ($cs < 5000) {
            return "Hasu";
        } elseif ($cs < 6000) {
            return "XaKaC";
        } elseif ($cs < 7000) {
            return "Idra";
        } elseif ($cs < 8000) {
            return "Trener";
        } elseif ($cs < 9000) {
            return "[СО!]";
        } elseif ($cs < 10000) {
            return "SuperHero";
        } elseif ($cs < 15000) {
            return "Gosu";
        } elseif ($cs < 20000) {
            return "IPXZerg";
        } elseif ($cs < 40000) {
            return "Savior";
        } elseif ($cs < 70000) {
            return "Lutshii";
        } elseif ($cs < 100000) {
            return "Bonjva";
        } elseif ($cs >= 100000) {
            return "Ebanutyi";
        }
    }

    public function checkUserLink($str)
    {
        if (preg_match('/^(http|https):\/\//i', $str)) {
            $url = $str;
        } else {
            $url = 'http://' . $str;
        }
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }
        return false;
    }
}
