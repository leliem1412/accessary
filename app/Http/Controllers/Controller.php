<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function responseSuccess($data = [], $message = [], $code = 200){
        return response()->json([
            'success'=>true,
            'code'=> $code,
            'message'=> $message ? $message : 'Success!',
            'data'=> $data,
        ]);
    }

    public function responseValidErrors($errors = [], $message = [], $code = 422){
        return response()->json([
            'success'=>false,
            'code'=> $code,
            'message'=> $message ? $message : 'Valid errors!',
            'errors'=> $errors
        ]);
    }

    public function responseSaveErrors($errors = [], $message = [], $code = 403){
        return response()->json([
            'success'=>false,
            'code'=> $code,
            'message'=> $message ? $message : 'Save fail!',
            'errors'=> $errors
        ]);
    }

    public function getCode($model, $codePrefix = '') {
        $latestId = $model::withTrashed()->max('id');
        $key = !empty($latestId) ? ($latestId + 1) : 1;
        
        return $codePrefix . $key;
    }
}
