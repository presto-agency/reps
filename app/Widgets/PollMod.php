<?php


namespace App\Widgets;


use AdminTemplate;

use SleepingOwl\Admin\Widgets\Widget;

class PollMod extends Widget
{
    /**
     * @return array|string
     * @throws \Throwable
     */
    public function toHtml()
    {
        return view('admin::polls');
    }

    /**
     * @return array|string
     */
    public function template()
    {
        return AdminTemplate::getViewPath('admin.poll');
    }

    /**
     * @return string
     */
    public function block()
    {
        return 'block.top';
    }


}
