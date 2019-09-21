<?php


namespace App\Widgets;


use AdminTemplate;
use App\User;
use SleepingOwl\Admin\Widgets\Widget;

class DashboardMap extends Widget
{
    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return view('admin.dashboard', [
            'UsersCount' => User::count(),
        ]);
    }

    /**
     * @return string|array
     */
    public function template()
    {
        return AdminTemplate::getViewPath('admin.dashboard');
    }

    /**
     * @return string
     */
    public function block()
    {
        return 'block.top';
    }


}
