<?php

namespace App\Http\Controllers;


class ReplayTypeController extends Controller
{
    public function show()
    {
        return view('replay.indexPro', ['checkProLS' => false]);
    }

}
