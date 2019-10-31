<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ForumSection extends Model
{
    protected $fillable = [
        'position', 'name', 'display_name', 'description', 'is_active', 'is_general', 'user_can_add_topics',
    ];
    public function topics()
    {
        return $this->hasMany('App\Models\ForumTopic');
    }
    public static function active()
    {
        return $general_forum = ForumSection::where('is_active',1)->orderBy('position');
    }

    public static function getUserTopics($user_id)
    {
        return ForumSection::whereHas('topics', function ($query) use ($user_id){
            $query->where('user_id', $user_id);
        })->with(['topics' => function($query1) use ($user_id){
            $query1->where('user_id',$user_id)
                ->withCount( /*'positive', 'negative', */'comments')
//                ->with('icon')
//                ->has('sectionActive')
                /*->with(['user'=> function($q){
                    $q->with('avatar')->withTrashed();
                }])*/
                ->where(function ($q){
                    $q->whereNull('start_on')
                        ->orWhere('start_on','<=', Carbon::now()->format('Y-m-d'));
                })
                /*->with(['comments' => function($query){
                    //TODO:remove "with comments"
                    $query->withCount('positive', 'negative')->orderBy('created_at', 'desc')->first();
                }])*/
                ->orderBy('created_at', 'desc');
        }])->get();
    }
}
