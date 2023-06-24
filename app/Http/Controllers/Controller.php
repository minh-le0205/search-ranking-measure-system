<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function render($error = true, $data = [], $msg = '', $statusCode = 200)
    {
        return response()->json([
            'message' => $msg,
            'error' => $error,
            'data_length' => count($data),
            'data' => $data
        ], $statusCode);
    }
}
