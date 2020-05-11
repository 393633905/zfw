<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fang;
use App\Models\FangAttr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FangAttrController extends Controller
{
    //房源属性列表页面：
    public function index(FangAttr $fangattr)
    {
        $data=$fangattr->getFangAttrList();
        return view('admin.fangattr.index',compact('data'));
    }

    //增加房源属性页面：
    public function create(FangAttr $fangAttr)
    {
        $data=$fangAttr::where('pid',0)->get();
        return view('admin.fangattr.create',compact('data'));
    }

    //上传房源属性图片：
    public function upfile(Request $request){
        if($request->hasFile('file')){
            $filename=$request->file('file')->store('','fang_attr');
            //返回上传成功后图片的路径：
            $filepath='/uploads/fang_attr/'.$filename;
            //返回路径地址：
            return ['code'=>200,'url'=>$filepath];
        }else{
            return ['code'=>404,'url'=>''];
        }
    }


    //房源属性保存：
    public function store(Request $request)
    {

        //表单验证通过后入库：
        $this->validate($request,[
            'name'=>'required'
        ]);

        //dd($request->except(['_token','file']));
        FangAttr::create($request->except(['_token','file']));
        //添加成功后跳转：
        return redirect(route('admin.fangattr.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FangAttr  $fangAttr
     * @return \Illuminate\Http\Response
     */
    public function show(FangAttr $fangAttr)
    {
        //
    }

    //房源属性修改页面
    public function edit(FangAttr $fangattr)
    {
        $data=$fangattr::where('pid',0)->get();//所有的房源
        return view('admin.fangattr.edit',compact('data','fangattr'));
    }

    //房源属性修改功能：
    public function update(Request $request, FangAttr $fangattr)
    {
        //表单验证通过后入库：
        $this->validate($request,[
            'name'=>'required'
        ]);

        $affected_rows=$fangattr->update($request->except(['_token','file']));
        if($affected_rows){
            //添加成功后跳转：
            return redirect(route('admin.fangattr.index'));
        }
    }

    //房源属性删除功能：
    public function destroy(FangAttr $fangattr)
    {
        //判断所有房源中是否与有关联的属性：
       // $fang=Fang::where('')->get();
        if($fangattr->delete()){
            return ['code'=>200,'msg'=>'删除成功'];
        }else{
            return ['code'=>500,'msg'=>'删除失败'];
        }

    }
}
