<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function successResponse($data, $code) 
    {
		return response()->json($data, $code);
	}

	protected function errorResponse($message, $code) {
        $data = [
            'status' => $code,
            'message' => $message
        ];

		return response()->json($data, $code);
    }
}
