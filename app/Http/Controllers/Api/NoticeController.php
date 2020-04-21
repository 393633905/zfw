<?php

namespace App\Http\Controllers\Api;

use App\Models\FangOwner;
use App\Models\Notice;
use App\Models\Rent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoticeController extends Controller
{
    //看房通知：
    public function get(Request $request){
       try{
           $this->validate($request,[
               'openid'=>'required'
           ]);
           $openid=$request->get('openid');
           $renting_id=Rent::where('openid',$openid)->value('id');
           $notice_model=Notice::where('renting_id',$renting_id)->with(['owner'])->orderBy('id','desc')->get();
           return response()->json(['status'=>200,'msg'=>'获取成功','data'=>$notice_model]);
       }catch (\Exception $exception){
           return response()->json(['status'=>10000,'msg'=>'请求参数错误'],401);
       }
    }
}
