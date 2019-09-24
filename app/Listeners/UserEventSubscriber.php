<?php


namespace App\Listeners;


use App\Models\UserActivityLog;
use App\Models\UserActivityType;
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
        $log = new UserActivityLog;
        $log->type_id = $typeId;
        $log->user_id = $event->user->id;
        $log->time = Carbon::now();
        $log->ip = \Request::getClientIp();
        $log->parameters = null;
        $log->save();
    }
}
