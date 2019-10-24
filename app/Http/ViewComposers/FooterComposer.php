<?php


namespace App\Http\ViewComposers;


use App\User;
use Carbon\Carbon;
use App\Models\{Footer, FooterUrl};
use Illuminate\View\View;

class FooterComposer
{
    private $category;

    public function __construct()
    {
        $data['footer'] = Footer::where('approved', 1)->value('text');
        $data['footerUrl'] = FooterUrl::where('approved', 1)->get(['title', 'url']);
        $data['footerUsers'] = User::where('birthday', Carbon::now()->format('Y-m-d'))->get(['name']);

        $this->category = $data;

    }

    public function compose(View $view)
    {
        $view->with('footerData', $this->category);
    }
}
