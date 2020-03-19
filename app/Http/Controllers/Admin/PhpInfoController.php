<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PhpInfoController extends Controller
{

    public function show()
    {
        return phpinfo();
    }

}
