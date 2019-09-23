<?php


namespace App\Listeners;


use App\Models\UserActivityLog;
use Carbon\Carbon;

class UserEventSubscriber
{
    /**
     * Handling a user login event.
     */
    public function onUserLogin($event)
    {

        $this->saveLog($event, 'Login');

    }

    /**
     * Handling a user logout event.
     */
    public function onUserLogout($event)
    {

        $this->saveLog($event, 'Logout');
    }

    /**
     * Register listeners for subscription.
     *
     * @param Illuminate\Events\Dispatcher $events
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
    }

    private function saveLog($event, $type)
    {
        $log = new UserActivityLog;
        $log->type = $type;
        $log->user_id = $event->user->id;
        $log->time = Carbon::now();
        $log->ip = \Request::getClientIp();
        $log->parameters = null;
        $log->save();
    }
}
