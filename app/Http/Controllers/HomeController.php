<?php

namespace App\Http\Controllers;

use App\Models\ForumTopic;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('home.index');
    }

}
