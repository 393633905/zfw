<?php

namespace App\Http\Controllers\Api;


use App\Models\Api\Fang;
use App\Models\FangAttr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FangAttrController extends Controller
{
    private $temp=[
        'fang_direction'=>0,
        'fang_rent_class'=>7,
        'fang_rent_type'=>10,
        'fang_config'=>14,
    ];

    //获取指定属性列表数据：
    public function get(Request $request){
        $temp=$this->temp;
        foreach ($temp as $key=>$value){
            $temp[$key]=FangAttr::where('pid',$value)->get(['id','name']);
        }
        return response()->json(['status'=>200,'msg'=>'获取成功','data'=>$temp]);
    }


}
