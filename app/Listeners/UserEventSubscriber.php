<?php


namespace App\Listeners;


use App\Models\Comment;
use App\Models\UserActivityLog;
use App\Models\UserActivityType;
use App\User;
use Carbon\Carbon;

class UserEventSubscriber
{
    /**
     * @param $event
     */
    public function onUserLogin($event)
    {
        $this->saveLog($event->user->id, $this->getIdTypeLog('Login'), null);
    }

    /**
     * @param $event
     */
    public function onUserLogout($event)
    {
        $this->saveLog($event->user->id, $this->getIdTypeLog('Logout'), null);
    }

    /**
     * @param $event
     */
    public function onUserRegistered($event)
    {
        $this->saveLog($event->user->id, $this->getIdTypeLog('Register'), null);
    }

    /**
     * @param $event
     */
    public function onUserUploadImage($event)
    {
        $this->saveLog($event->userGallery->user_id, $this->getIdTypeLog('Upload Image'), $event->userGallery->id);
    }

    /**
     * @param $event
     */
    public function onUserUploadReplay($event)
    {
        $this->saveLog($event->userReplay->user_id, $this->getIdTypeLog('Upload Replay'), $event->userReplay->id);
    }

    /**
     * @param $event
     */
    public function onUserUploadForumTopic($event)
    {
        $this->saveLog($event->userForumTopic->user_id, $this->getIdTypeLog('Create Post'), $event->userForumTopic->id);
    }

    /**
     * @param $event
     */
    public function onUserComment($event)
    {
        $this->saveLog($event->userComment->user_id, $this->getIdTypeLog('Comment'), $event->userComment->id);
    }

    /**
     * Events list
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
     * @param $parameters_id -> id of event
     */
    private function saveLog($user_id, $type_id, $parameters_id)
    {

        $log = new UserActivityLog;
        $log->type_id = $type_id;
        $log->user_id = $user_id;
        $log->time = Carbon::now();
        $log->ip = \Request::getClientIp();
        $log->parameters = $parameters_id;
        $log->save();

        $this->updateUserLastActivity($user_id);
    }

    /**
     * @param $user_id
     * @return mixed
     */
    private function updateUserLastActivity($user_id)
    {
        return User::where('id', $user_id)->select('activity_at')->update([
            'activity_at' => Carbon::now()
        ]);
    }

    /**
     * @param $name
     * @return mixed
     */
    private function getIdTypeLog($name)
    {
        return UserActivityType::where('name', $name)->value('id');
    }
}
