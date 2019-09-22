<?php


namespace App\Http\ViewComposers;

use App\User;
use Illuminate\View\View;

class UserComposer
{

    private $category;

    public function __construct()
    {
        $this->category = collect();

        $data = User::count();

        $this->category = $data;

    }

    public function compose(View $view)
    {

        $view->with('user',$this->category);
    }
}
