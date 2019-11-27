<?php


namespace App\Listeners;


use App\Models\UserActivityLog;
use App\User;
use Carbon\Carbon;

class UserEventSubscriber
{

    /**
     * @param $event
     */
    public function onUserVerified($event)
    {
                $this->saveLog($event->user->id, UserActivityLog::EVENT_USER_VERIFIED, null);
    }

    /**
     * @param $event
     */
    public function onUserLogin($event)
    {

                $this->saveLog($event->user->id, UserActivityLog::EVENT_USER_LOGIN, null);
    }

    /**
     * @param $event
     */
    public function onUserLogout($event)
    {
        if (!empty($event->user)){
            $this->saveLog($event->user->id, UserActivityLog::EVENT_USER_LOGOUT, null);

        }
    }

    /**
     * @param $event
     */
    public function onUserRegistered($event)
    {

                $this->saveLog($event->user->id, UserActivityLog::EVENT_USER_REGISTER, null);
    }

    /**
     * @param $event
     */
    public function onUserUploadImage($event)
    {
        //        $this->saveLog($event->userGallery->user_id, UserActivityLog::EVENT_CREATE_IMAGE, UserActivityLogService::parametersForCreateImage($event->userGallery));
    }

    /**
     * @param $event
     */
    public function onUserUploadReplay($event)
    {
        //        $this->saveLog($event->userReplay->user_id, UserActivityLog::EVENT_CREATE_REPLAY, UserActivityLogService::parametersForCreateReplay($event->userReplay));
    }

    /**
     * @param $event
     */
    public function onUserUploadForumTopic($event)
    {
        //        $this->saveLog($event->userForumTopic->user_id, UserActivityLog::EVENT_CREATE_POST, UserActivityLogService::parametersForCreateTopic($event->userForumTopic));
    }

    /**
     * @param $event
     */
    public function onUserComment($event)
    {
        //        $this->saveLog($event->userComment->user_id, UserActivityLog::EVENT_USER_COMMENT, null);
    }

    /**
     * Events list
     *
     * @param $events
     */
    public function subscribe($events)
    {

        $events->listen(
            'IIlluminate\Auth\Events\Verified',
            'App\Listeners\UserEventSubscriber@onUserVerified'
        );
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
     * @param $type
     * @param $parameters
     */
    private function saveLog($user_id, $type, $parameters)
    {

        $log             = new UserActivityLog;
        $log->type       = $type;
        $log->user_id    = $user_id;
        $log->time       = Carbon::now();
        $log->ip         = ! empty(\Request::getClientIp())
            ? \Request::getClientIp() : '';
        $log->parameters = $parameters;
        $log->save();

        $this->updateUserLastActivity($user_id);
    }

    /**
     * @param $user_id
     *
     * @return mixed
     */
    private function updateUserLastActivity($user_id)
    {
        return User::where('id', $user_id)->select('activity_at')->update([
            'activity_at' => Carbon::now(),
        ]);
    }

}
