<?php

namespace App\Traits;

trait AjaxResponser{

    public function success($message, $data, $status){
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'status' => $status
        ]);
    }

    public function error($message, $data, $status){
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
            'status' => $status
        ]);
    }
}