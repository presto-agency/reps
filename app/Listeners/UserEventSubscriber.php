<?php


namespace App\Listeners;


use App\Models\Comment;
use App\Models\UserActivityLog;
use App\Models\UserActivityType;
use App\User;
use Carbon\Carbon;

class UserEventSubscriber
{

    public function onUserLogin($event)
    {
        $this->saveLog($event->user->id, $this->getIdTypeLog('Login'), null);
    }


    public function onUserLogout($event)
    {
        $this->saveLog($event->user->id, $this->getIdTypeLog('Logout'), null);
    }

    public function onUserRegistered($event)
    {
        $this->saveLog($event->user->id, $this->getIdTypeLog('Register'), null);
    }

    public function onUserUploadImage($event)
    {
        $this->saveLog($event->userGallery->user_id, $this->getIdTypeLog('Upload Image'), "Изображение " . $event->sign);
    }

    public function onUserUploadReplay($event)
    {

        $this->saveLog($event->userReplay->user_id, $this->getIdTypeLog('Upload Replay'), "Replay " . $event->user_replay);
    }

    public function onUserUploadForumTopic($event)
    {

        $this->saveLog($event->userForumTopic->user_id, $this->getIdTypeLog('Create Post'), "Пост " . $event->title);
    }

    public function onUserComment($event)
    {
        $comment = Comment::with('commentable')->find($event->userComment->id);
        $this->saveLog($event->userComment->user_id, $this->getIdTypeLog('Comment'), "Комментарий для " . $comment->commentable->user_replay);
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@onUserLogout'
        );

        $events->listen(
            'Illuminate\Auth\Events\Registered',
            'App\Listeners\UserEventSubscriber@onUserRegistered'
        );

        $events->listen(
            'App\Events\UserUploadImage',
            'App\Listeners\UserEventSubscriber@onUserUploadImage'
        );

        $events->listen(
            'App\Events\UserUploadReplay',
            'App\Listeners\UserEventSubscriber@onUserUploadReplay'
        );

        $events->listen(
            'App\Events\UserUploadForumTopic',
            'App\Listeners\UserEventSubscriber@onUserUploadForumTopic'
        );

        $events->listen(
            'App\Events\UserComment',
            'App\Listeners\UserEventSubscriber@onUserComment'
        );

    }

    /**
     * @param $user_id
     * @param $type_id
     * @param $parameters
     */
    private function saveLog($user_id, $type_id, $parameters)
    {


        $log = new UserActivityLog;
        $log->type_id = $type_id;
        $log->user_id = $user_id;
        $log->time = Carbon::now();
        $log->ip = \Request::getClientIp();
        $log->parameters = $parameters;
        $log->save();

        User::where('id', $user_id)->select('activity_at')->update([
            'activity_at' => Carbon::now()
        ]);


    }

    private function getIdTypeLog($name)
    {
        return UserActivityType::where('name', $name)->value('id');
    }
}
