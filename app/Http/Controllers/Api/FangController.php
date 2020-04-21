<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Fang;
use App\Models\Api\FangCollect;
use App\Models\FangAttr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FangController extends BaseController
{

    //房屋推荐：
    public function recommend(Request $request){
        $field=[
            'id','fang_name','fang_xiaoqu','fang_build_area','fang_rent','fang_pic','fang_shi','fang_ting','fang_wei','fang_rent_type','fang_rent_class'
        ];
        $fang_model=Fang::where('is_recommend',"1")->limit(5)->orderBy('id','desc')->get($field);

        return response()->json(['status'=>200,'msg'=>'获取成功','data'=>$fang_model]);
    }

    //所有房屋信息：
    public function get(Request $request){
        $field=[
            'id','fang_name','fang_xiaoqu','fang_build_area','fang_rent','fang_pic','fang_shi','fang_ting','fang_wei','fang_rent_type','fang_rent_class'
        ];
        $fang_model=Fang::where('fang_status',0)->orderBy('id','desc')->select($field)->paginate(5);

        return response()->json(['status'=>200,'msg'=>'获取成功','data'=>$fang_model]);
    }

    //含指定名称的属性：
    public function attr(Request $request){
        try{
            $this->validate($request,[
                'field'=>'required'
            ]);

            $field_name=$request->get('field');

            $parent_id=FangAttr::where('field_name',$field_name)->value('id');
            $fang_model=FangAttr::where('pid',$parent_id)->get(['id','name','icon']);

            if($field_name=='fang_rent_class'){
                foreach ($fang_model as $item){
                    if($item['name']=='整租'){
                        $item['intro']='海量房源';
                    }else{
                        $item['intro']='省钱合租';
                    }
                }
            }

            return response()->json(['status'=>200,'msg'=>'获取成功','data'=>$fang_model]);
        }catch (\Exception $exception){
            return response()->json(['status'=>10000,'msg'=>'请求参数不完整','data'=>$exception->getMessage()],500);
        }
    }

    //获取指定房源详情：
    public  function item(Fang $fang){
        $fang->owner=$fang->owner;
        $ret=FangAttr::whereIn('id',explode(',',$fang->fang_config))->get(['name','icon']);
        $fang->fang_config=$ret;
        return response()->json(['status'=>200,'msg'=>'获取成功','data'=>$fang]);
    }

    //获取指定属性的所有房源数据：
    public function getAttrWithFang(Request $request){
        try{
            $param=$this->validate($request,[
                'attr_id'=>'required|numeric',
                'field'=>'required',
            ]);
            $field=[
                'id','fang_name','fang_xiaoqu','fang_build_area','fang_rent','fang_pic','fang_shi','fang_ting','fang_wei','fang_rent_type','fang_rent_class'
            ];
            $data=Fang::where($param['field'],$param['attr_id'])->get($field);
            return $this->responseSuccess($data);
        }catch (\Exception $exception){
            echo $exception->getMessage();
            return $this->responseError('10000','请求参数不合规范',401);
        }
    }

    //es搜索：获取目标数据的id,然后在mysql中wherein即可
   public function esSearch(Request $request){

        $kw=$request->get('kw');
        if(empty($kw)){
            return $this->responseError('10000','请传入搜索关键字','200');
        }

        $client = \Elasticsearch\ClientBuilder::create()->setHosts(config('es.host'))->build();
        $params = [
            'index' => 'fang',
            'type' => '_doc',
            'body' => [
                'query' => [
                    'match' => [
                        'fang_desn'=>[
                            'query' => $kw
                        ]
                    ]
                ]
            ]
        ];
         $results = $client->search($params);

         if($results['hits']['total']){
             $ids=array_column($results['hits']['hits'],'_id');
             $field=[
                 'id','fang_name','fang_xiaoqu','fang_build_area','fang_rent','fang_pic','fang_shi','fang_ting','fang_wei','fang_rent_type','fang_rent_class'
             ];
             return Fang::whereIn('id',$ids)->get($field);
         }
    }


    //获取房源收藏：根据用户openid来获取
    public function getCollect(Request $request){
        $openid=$request->get('openid');
        if(empty($openid)){
           return $this->responseError('10000','请求参数不合规范','401');
        }
        $data=FangCollect::where('openid',$openid)->get(['id','openid','fang_id']);
        return $this->responseSuccess($data);
    }

    //删除指定收藏：根据传入的openid和房源id进行删除
    public function destroyCollect(Request $request){
        try{
            $param=$this->validate($request,[
                'openid'=>'required',
                'fang_id'=>'required'
            ]);
            $affect_rows=FangCollect::where('openid',$param['openid'])->where('fang_id',$param['fang_id'])->delete();
            if($affect_rows>0){
                return $this->responseSuccess([]);
            }
        }catch (\Exception $exception){
            return $this->responseError('10000','请求参数不合规范','401');
        }
    }

    //设置收藏：根据openid和fang_id进行设置
    public function setCollect(Request $request){
        try{
            $param=$this->validate($request,[
                'openid'=>'required',
                'fang_id'=>'required'
            ]);
            $model=FangCollect::create($param);
            $data=FangCollect::find($model->id);
            return $this->responseSuccess($data);
        }catch (\Exception $exception){
            return $this->responseError('10000','请求参数不合规范','401');
        }
    }

}
