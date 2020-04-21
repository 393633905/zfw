<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

class BaseController extends Controller{

    //响应成功的json格式：
    protected function responseSuccess($data){
        return response()->json(['status'=>200,'msg'=>'success','data'=>$data]);
    }

    //响应错误的json格式：
    protected function responseError($status,$msg,$http_code){
        return response()->json(['status'=>$status,'msg'=>$msg,'data'=>[]],$http_code);
    }

}