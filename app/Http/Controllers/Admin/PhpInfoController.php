<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Class PhpInfoController
 *
 * @package App\Http\Controllers\Admin
 */
class PhpInfoController extends Controller
{

    /**
     * @return string
     */
    public function show(): string
    {
        phpinfo();

        return '';
    }

}
