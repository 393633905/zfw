<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function index(Request $request){
        $method=$request->method();
        if($method=='GET'){
            if(auth()->check()){
                return view('admin.index.index');
            }
            return view('admin.login.login');
        }else if ($method=='POST'){//登录：
            //表单验证：
            $rule=[
                'username'=>'required',
                'password'=>'required'
            ];
            $param=$this->validate($request,$rule);
            //登录：
            if(auth()->attempt($param)){//成功
                //成功跳转：
                return redirect(route('admin.index'));
            }else{
                //失败跳转到登录页，并使用withErrors（会将错误信息存入特殊的session(闪存)，此闪存仅第一次请求时显示）
                return redirect(route('admin.login'))->withErrors(['error'=>'用户名或密码错误']);
            }
        }
    }

    public function logout(){
        auth()->logout();
        //with也是将信息存入特殊的session中（闪存）
        return redirect(route('admin.login'))->with('success','退出成功');
    }
}
