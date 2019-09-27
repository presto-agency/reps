<?php


namespace App\Listeners;


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
        $typeId = UserActivityType::where('name', 'Login')->select('id')->first()->id;
        $this->saveLog($event, $typeId);

    }

    /**
     * @param $event
     */
    public function onUserLogout($event)
    {
        $typeId = UserActivityType::where('name', 'Logout')->select('id')->first()->id;
        $this->saveLog($event, $typeId);
    }

    public function onUserRegistered($event)
    {
        $typeId = UserActivityType::where('name', 'Register')->select('id')->first()->id;
        $this->saveLog($event, $typeId);
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
    }

    /**
     * @param $event
     * @param $typeId
     */
    private function saveLog($event, $typeId)
    {

        $userId = $event->user->id;

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
