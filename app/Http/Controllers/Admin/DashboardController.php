<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    /**
     * @return mixed
     */
    public function index()
    {
        $content = view('admin.dashboard');

        return AdminSection::view($content);
    }

}
