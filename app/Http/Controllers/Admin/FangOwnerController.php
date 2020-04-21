<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FangOwnerExport;
use App\Models\FangOwner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class FangOwnerController extends BaseController
{
    /**
     * 房东列表页面：
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=FangOwner::paginate($this->pageSize);
        return view('admin.fangowner.index',compact('data'));
    }

    //导出excel
    public function exports(){
        return Excel::download(new FangOwnerExport, 'FangOwner.xlsx');
    }

    //上传文件：
    public function upfile(Request $request){
        if($request->hasFile('file')){
            $filename=$request->file('file')->store('','fang_owner');
            //返回上传成功后图片的路径：
            $filepath='/uploads/fang_owner/'.$filename;
            //返回路径地址：
            return ['code'=>200,'url'=>$filepath];
        }else{
            return ['code'=>404,'url'=>''];
        }
    }

    /**
     * 添加房东页面：
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.fangowner.create');
    }

    /**
     * 添加房东功能：
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->except(['_token','file']));
        FangOwner::create($request->except(['_token','file']));
        return redirect(route('admin.fangowner.index'))->with('success','添加房东成功');
    }

    /**
     * 查看身份证图片：
     *
     * @param  \App\Models\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function show(FangOwner $fangowner)
    {
        $pic=$fangowner->pic;
        //去除最后一个空格,并按照‘#’将字符串分割为数组：
        $pic=explode('#',substr($pic,0,strlen($pic)-1));
        array_map(function($v){
            echo "<div><img src=$v></div>";
        },$pic);
    }

    public function delfile(Request $request){
        if($url=$request->get('url')){
            unlink(public_path($url));
            return ['code'=>200,'msg'=>'删除成功'];
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function edit(FangOwner $fangowner)
    {
       //return view('admin.fangowner.edit',compact('fangowner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FangOwner $fangowner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function destroy(FangOwner $fangowner)
    {
        //
    }
}
