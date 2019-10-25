<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReplayController extends Controller
{
    public function show()
    {
        return view('replay.index', ['checkProLS' => true]);
    }
}
