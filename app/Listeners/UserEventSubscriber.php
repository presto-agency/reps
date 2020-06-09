<?php


namespace App\Listeners;


use App\Models\UserActivityLog;
use App\Services\User\UserActivityLogService;
use Carbon\Carbon;
use DB;
use Request;

class UserEventSubscriber
{

    /**
     * @param $event
     */
    public function onUserVerified($event)
    {
        if ( ! empty($event->user)) {
            $this->saveLog($event->user->id, UserActivityLog::EVENT_USER_VERIFIED, null);
        }
    }

    /**
     * @param $user_id
     * @param $type
     * @param $parameters
     */
    private function saveLog($user_id, $type, $parameters)
    {
        $data = [
            'type'       => $type,
            'user_id'    => $user_id,
            'time'       => Carbon::now(),
            'ip'         => ! empty(Request::getClientIp()) ? Request::getClientIp() : '',
            'parameters' => $parameters,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        DB::table('user_activity_logs')->insert($data);
        $this->updateUserLastActivity($user_id);
    }

    /**
     * @param $user_id
     *
     * @return mixed
     */
    private function updateUserLastActivity($user_id)
    {
        DB::table('users')->where('id', $user_id)->update([
            'activity_at' => Carbon::now(),
            'updated_at'  => Carbon::now(),
        ]);

        return null;
    }

    /**
     * @param $event
     */
    public function onUserLogin($event)
    {
        if ( ! empty($event->user)) {
            $this->saveLog($event->user->id, UserActivityLog::EVENT_USER_LOGIN, null);
        }
    }

    /**
     * @param $event
     */
    public function onUserLogout($event)
    {
        if ( ! empty($event->user)) {
            $this->saveLog($event->user->id, UserActivityLog::EVENT_USER_LOGOUT, null);
        }
    }

    /**
     * @param $event
     */
    public function onUserRegistered($event)
    {
        if ( ! empty($event->user)) {
            $this->saveLog($event->user->id, UserActivityLog::EVENT_USER_REGISTER, null);
        }
    }

    /**
     * @param $event
     */
    public function onUserUploadImage($event)
    {
        if ( ! empty($event->userGallery)) {
            $this->saveLog($event->userGallery->user_id, UserActivityLog::EVENT_CREATE_IMAGE,
                UserActivityLogService::parametersForCreateImage($event->userGallery));
        }
    }

    /**
     * @param $event
     */
    public function onUserUploadReplay($event)
    {
        if ( ! empty($event->userReplay)) {
            $this->saveLog($event->userReplay->user_id, UserActivityLog::EVENT_CREATE_REPLAY,
                UserActivityLogService::parametersForCreateReplay($event->userReplay));
        }
    }

    /**
     * @param $event
     */
    public function onUserUploadForumTopic($event)
    {
        if ( ! empty($event->userForumTopic)) {
            $this->saveLog($event->userForumTopic->user_id, UserActivityLog::EVENT_CREATE_POST,
                UserActivityLogService::parametersForCreateTopic($event->userForumTopic));
        }
    }

    /**
     * @param $event
     */
    public function onUserComment($event)
    {
        if ( ! empty($event->userComment)) {
            $this->saveLog($event->userComment->user_id, UserActivityLog::EVENT_USER_COMMENT,
                UserActivityLogService::parametersForComment($event->userComment));
        }
    }

    /**
     * @param $event
     */
    public function onUserLike($event)
    {
        if ( ! empty($event->userReputation)) {
            $this->saveLog($event->userReputation->sender_id, UserActivityLog::EVENT_USER_COMMENT,
                UserActivityLogService::parametersForLike($event->userReputation));
        }
    }

    /**
     * Events list
     *
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Verified',
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
        $events->listen(
            'App\Events\UserLike',
            'App\Listeners\UserEventSubscriber@onUserLike'
        );
    }

}
