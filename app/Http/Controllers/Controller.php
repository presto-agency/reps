<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Info(
     *   version=L5_SWAGGER_CONST_VERSION,
     *   title=L5_SWAGGER_CONST_TITLE,
     * )
     * @OA\PathItem(path="/api"),
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description=L5_SWAGGER_CONST_HOST_DESCRIPTION
     *  )
     */


}
