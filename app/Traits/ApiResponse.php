<?php

namespace App\Traits;

trait ApiResponse
{
    //
    public function success($data = null, $message = 'Success',$code=200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function error($message = 'Error', $code = 500)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }
}
