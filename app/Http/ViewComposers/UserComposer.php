<?php


namespace App\Http\ViewComposers;

use Illuminate\View\View;

class UserComposer
{

    private $category;

    public function __construct()
    {
        $this->category = collect();

        $data = \DB::table('users')->select('id')->count();

        $this->category = $data;

    }

    public function compose(View $view)
    {

        $view->with('user', $this->category);
    }
}
