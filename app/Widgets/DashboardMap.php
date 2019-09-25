<?php


namespace App\Widgets;


use AdminTemplate;
use App\User;
use SleepingOwl\Admin\Widgets\Widget;

class DashboardMap extends Widget
{
    /**
     * @return array|string
     * @throws \Throwable
     */
    public function toHtml()
    {
        return view('admin.dashboard')->render();
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
