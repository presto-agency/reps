<?php

namespace App\Widgets;

use AdminTemplate;
use SleepingOwl\Admin\Widgets\Widget;

class NavigationUserBlock extends Widget
{
    /**
     * @return array|string
     * @throws \Throwable
     */
    public function toHtml()
    {
        return view('admin::auth.navbar', [
            'user' => auth()->user()
        ])->render();
    }

    /**
     * @return array|string
     */
    public function template()
    {
        return AdminTemplate::getViewPath('_partials.header');
    }

    /**
     * @return string
     */
    public function block()
    {
        return 'navbar.right';
    }
}
