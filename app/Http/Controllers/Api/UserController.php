<?php

namespace App\Http\Controllers\Api;

use App\Models\Rent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //获取用户信息：
    public function get(Request $request){
        try{
            $openid=$request->get('openid');
            $rent_model=Rent::where('openid',$openid)->first();
            $data=[
                'openid'=>$rent_model->openid,
                'nickname'=>$rent_model->nickname,
                'phone'=>$rent_model->phone,
                'sex'=>$rent_model->sex,
                'age'=>$rent_model->age,
                'avatar'=>$rent_model->avatar,
                'card'=>$rent_model->card,
                'card_img'=>$rent_model->card_img,
                'is_auth'=>$rent_model->is_auth
            ];
            return response()->json(['status'=>200,'msg'=>'获取成功','data'=>$data]);
        }catch (\Exception $exception){
            return response()->json(['status'=>10000,'msg'=>'请求参数错误'],401);
        }
    }

    //修改用户信息：
    public function set(Request $request){
        try{
            $this->validate($request,[
               'openid'=>'required',
            ]);
            //openid:
            $openid=$request->get('openid');
            $affectedRows=Rent::where('openid',$openid)->update($request->except('openid'));
            if($affectedRows>0){
                $openid=$request->get('openid');
                $rent_model=Rent::where('openid',$openid)->first();
                $data=[
                    'openid'=>$rent_model->openid,
                    'nickname'=>$rent_model->nickname,
                    'phone'=>$rent_model->phone,
                    'sex'=>$rent_model->sex,
                    'age'=>$rent_model->age,
                    'avatar'=>$rent_model->avatar,
                    'card'=>$rent_model->card,
                    'card_img'=>$rent_model->card_img,
                    'is_auth'=>$rent_model->is_auth
                ];
                return response()->json(['status'=>201,'msg'=>'修改成功','data'=>$data],201);
            }
        }catch (\Exception $exception){
            return response()->json(['status'=>10000,'msg'=>'请求参数错误'],401);
        }
    }

    //上传身份证照片：
    public function upCardFile(Request $request){
        try{
            if($request->has('file')){
                $openid=$request->get('openid');
                //以openid为中间目录：
                $filename=$request->file('file')->store($openid,'wechat');
                $filepath='/uploads/wechat/'.$filename;
                return response()->json(['status'=>200,'msg'=>'上传成功','url'=>config('wechat.host').$filepath]);
            }else{
                return response()->json(['status'=>10001,'msg'=>'无图片上传'],500);
            }
        }catch(\Exception $exception){
            return response()->json(['status'=>10000,'msg'=>'请求参数错误'],401);
        }
    }
}
