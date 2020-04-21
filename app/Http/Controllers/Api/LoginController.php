<?php

namespace App\Http\Controllers\Api;

use App\Models\Apiuser;
use App\Models\Rent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    //接口登录：
    public function login(Request $request){
        try{
            //参数验证：
            $param=$this->validate($request,[
                'username'=>'required',
                'password'=>'required'
            ]);
            //使用attempt()验证：
            if(auth()->guard('apiserver')->attempt($param)){//验证通过
                $user_model=auth()->guard('apiserver')->user();

                if($user_model->click > env('LOGIN_CLICK')){
                    return response()->json(['status'=>200,'msg'=>'当天请求次数过多'],500);
                }
                //请求次数递增：
                $user_model->increment('click');
                //生成token:传入的参数与中间件名称一致
                $token=$user_model->createToken('api')->accessToken;
                return response()->json(['expire'=>7200,'token'=>$token]);
            }else{
                return response()->json(['status'=>10001,'msg'=>'用户名或密码错误'],400);
            }
        }catch (\Exception $exception){
            return response()->json(['status'=>10000,'msg'=>'用户名或密码不能为空'],401);
        }
    }

    //微信小程序登录：用于获取openId
    public function wxlogin(Request $request){
        $code=$request->get('code');
        $appId='wx79a2735f69941487';
        $appSecret='46c502ace14177eddfcb0ef20ec2eed2';
        $url=sprintf(config('wechat.auth'),$appId,$appSecret,$code);
        $res=Apiuser::get($url);
        if(!Rent::where('openid',$res['openid'])->first()){
            //openid不存在，入库：
            Rent::create($res);
        }
        //返回结果：
        return response()->json(['status'=>200,'msg'=>'获取成功','openid'=>$res['openid']]);
    }
}
