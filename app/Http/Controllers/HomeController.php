<?php

namespace App\Http\Controllers;

use App\Models\ForumTopic;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $isAdmin = 0;
        if(Auth::check()){
            $isAdmin = auth()->user()->isNotUser();
        }


        return view('home.index', compact('isAdmin'));
    }
}
