<?php

namespace App\Http\Controllers\Replay;

use App\Http\Controllers\Controller;

class ReplayController extends Controller
{
    public function showUser()
    {
        return view('replay.index', ['checkProLS' => true]);
    }

    public function showPro()
    {
        return view('replay.indexPro', ['checkProLS' => false]);
    }
}
