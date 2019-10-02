<?php


namespace App\Listeners;


use App\Models\UserActivityLog;
use App\Models\UserActivityType;
use App\User;
use Carbon\Carbon;

class UserEventSubscriber
{

    public function onUserLogin($event)
    {
        $typeId = UserActivityType::where('name', 'Login')->select('id')->first()->id;
        $this->saveLog($event->user->id, $typeId);

    }


    public function onUserLogout($event)
    {
        dd($event);
        $typeId = UserActivityType::where('name', 'Logout')->select('id')->first()->id;
        $this->saveLog($event->user->id, $typeId);
    }

    public function onUserRegistered($event)
    {
        $typeId = UserActivityType::where('name', 'Register')->select('id')->first()->id;
        $this->saveLog($event->user->id, $typeId);
    }

    public function onUserUploadImage($event)
    {

        $typeId = UserActivityType::where('name', 'Upload Image')->select('id')->first()->id;
        $this->saveLog($event->userGallery->user_id, $typeId);
    }

    public function onUserUploadReplay($event)
    {

        $typeId = UserActivityType::where('name', 'Upload Replay')->select('id')->first()->id;
        $this->saveLog($event->userReplay->user_id, $typeId);
    }
    public function onUserUploadForumTopic($event)
    {

        $typeId = UserActivityType::where('name', 'Create Post')->select('id')->first()->id;
        $this->saveLog($event->userForumTopic->user_id, $typeId);
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

    }

    /**
     * @param $userId
     * @param $typeId
     */
    private function saveLog($userId, $typeId)
    {


        $log = new UserActivityLog;
        $log->type_id = $typeId;
        $log->user_id = $userId;
        $log->time = Carbon::now();
        $log->ip = \Request::getClientIp();
        $log->parameters = null;
        $log->save();

        User::where('id', $userId)->select('activity_at')->update([
            'activity_at' => Carbon::now()
        ]);


    }
}
