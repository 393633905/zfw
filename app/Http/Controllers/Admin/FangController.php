<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FangRequest;
use App\Models\City;
use App\Models\Fang;
use App\Models\FangAttr;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FangController extends BaseController
{


    public function search($keyword){
        $client = \Elasticsearch\ClientBuilder::create()->setHosts(config('es.host'))->build();
        $params = [
            'index' => 'fang',
            'type' => '_doc',
            'body' => [
                'query' => [
                    'match' => [
                        'desn'=>[
                            'query' => $keyword
                        ]
                    ]
                ]
            ]
        ];
        $results = $client->search($params);
        return $results;
    }
    /**
     * 房源信息列表：
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($keyword=$request->get('keyword')){
            //暂时不做搜索，因数据并未全部迁移到ES中
        }
        $data=Fang::with(['owner','direction','rent'])->paginate($this->pageSize);

        return view('admin.fang.index',compact('data'));
    }


    /**
     * 添加房源页面：
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Fang $fang)
    {
        //获取所有相关房源属性数据用于下拉选择，因修改也需要用到这类数据，故封装在模型中；
        $data=$fang->getRelationData();
        return view('admin.fang.create',$data);
    }

    //获取市县数据：
    public function city(Request $request){
        if($id=$request->get('id')){
            $data=City::where('pid',$id)->get();
            return ['code'=>200,'msg'=>'查询成功','data'=>$data,'id'=>$id];
        }
    }

    //上传房屋图片：
    public function upfile(Request $request){
        if($request->hasFile('file')){
            $filename=$request->file('file')->store('','fang');
            $filepath='/uploads/fang/'.$filename;
            return ['code'=>200,'url'=>$filepath];
        }
    }

    //删除上传图片：
    public function delfile(Request $request){
        if($url=$request->get('url')){
            unlink(public_path($url));
            return ['code'=>200,'msg'=>'删除成功'];
        }
    }
    /**
     * 添加房源功能：入库时，使用消息队列来完成ES添加数据
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FangRequest $request)
    {
        $param=$request->except('_token','file');
        //表单验证封装在了FangRequest类中：
        $fang_model=new Fang();
        //获取经纬度：
        $transformAddData=$fang_model->transAddress($request->get('fang_addr'),$fang_model->getCityName($request->get('fang_city')));
        if(!$transformAddData){
            return redirect(route('admin.fang.create'))->withErrors(['房源地址错误']);
        }
        $location=explode(',',$transformAddData['geocodes'][0]['location']);
        $param['longitude']=$location[0];
        $param['latitude']=$location[1];
        unset($location);unset($transformAddData);

        //入库：
        Fang::create($param);

        return redirect(route('admin.fang.index'))->with('success','添加房源成功');
    }

    //创建房源索引：存储数据
    public function esinit(){
       try{
           $client = ClientBuilder::create()->setHosts(config('es.host'))->build();
           // 创建索引
           $params = [
               'index' => 'fang',
               'body' => [
                   'settings' => [
                       'number_of_shards' => 5,//分片数
                       'number_of_replicas' => 1//副本数
                   ],
                   'mappings' => [
                       '_doc' => [
                           '_source' => [
                               'enabled' => true
                           ],
                           //字段：
                           'properties' => [
                               'fang_name' => [
                                   //keyword相当于数据查询的"="
                                   'type' => 'keyword'
                               ],
                               'fang_desn' => [
                                   //text相当于数据库查询中的like
                                   'type' => 'text',
                                   'analyzer' => 'ik_max_word',//使用ik中文分词
                                   'search_analyzer' => 'ik_max_word'
                               ]
                           ]
                       ]
                   ]
               ]
           ];
           $response = $client->indices()->create($params);
        }catch (\Exception $exception){
            return $exception->getMessage();
       }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    public function show(Fang $fang)
    {
        //
    }

    /**
     * 显示修改房源页面：
     * - 1.全部关联数据
     * - 2.三级联动数据
     * - 3.图片数据显示的处理
     *
     * @param  \App\Models\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    public function edit(Fang $fang)
    {
        $data=$fang->getRelationData();//全部属性关联数据
        $data['fang']=$fang;//当前房源所有数据
        $data['city']=City::where('pid',$fang->fang_province)->get();//当前房源所属的城市数据
        $data['region']=City::where('pid',$fang->fang_city)->get();//当前房源所属的县/区数据
        return view('admin.fang.edit',$data);
    }

    /**
     * 更新房源信息功能：
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fang $fang)
    {
        //表单验证：
        $param=$request->except(['_token','file']);
        //入库：
        $fang->update($param);
        return redirect(route('admin.fang.index'))->with('success','修改房源信息成功');
    }

    //改变房屋出租状态：
    public function stat(Request $request){
        try{
            $param=$this->validate($request,[
                'id'=>'required',
                'fang_status'=>'required',
            ]);
            $affected=Fang::where('id',$param['id'])->update(['fang_status'=>$param['fang_status']]);

            if($affected>0){
                return response()->json(['code'=>200,'msg'=>'修改出租状态成功'],200);
            }else{
                return response()->json(['code'=>500,'msg'=>'修改出租状态失败'],500);
            }
        }catch (\Exception $exception){

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fang $fang)
    {
        //
    }
}
