<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * 文章列表：使用datatables
     * @return \Illuminate\Http\Response就
     */
    public function index(Request $request)
    {
        if($request->header('X-Requested-With')=='XMLHttpRequest'){//如果是ajax请求
            $query=Article::where('id','>',0);

            //排序：
            //解构赋值：
            ['dir'=>$dir,'column'=>$column]=$request->get('order')[0];
            $order=$dir;
            $orderField=$request->get('columns')[$column]['data'];

            //搜索功能：
            $datemin=$request->get('datemin');
            $datemax=$request->get('datemax');
            $title=$request->get('title');


            if(!empty($datemin) && !empty($datemax)){
                //strtotime：将指定格式转换为时间戳，date表示将时间戳转换为指定格式
                $datemin=date('Y-m-d H:i:s',strtotime($datemin.'00:00:00'));
                $datemax=date('Y-m-d H:i:s',strtotime($datemax.'23:59:59'));
                $query->whereBetween('created_at',[$datemin,$datemax]);//where created_at between(1,2)
            }
            if(!empty($title)){
                $query->where('title','like',"%{$title}%");
            }

            //分页功能：
            $startRows=$request->get('start',0);
            $pageSize=min(50,$request->get('length',10));//如果取出的超过50，则最多取50条数据
            $count=$query->count();
            $articles=$query->offset($startRows)->limit($pageSize)->orderBy($orderField,$order)->get();
            $result = [
                'draw' => $request->get('draw'),
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $articles
            ];
            return json_encode($result,JSON_UNESCAPED_UNICODE);
        }
        return view('admin.article.index');
    }

    /**
     * 显示添加页面：
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.article.create');
    }

    //异步文件上传
    public function upfile(Request $request){
        if($request->hasFile('file')){//webuploader默认上传name为file
            //返回上传图片后重新编码的名称：
            $filename=$request->file('file')->store('','article');
            //返回路径地址：
            return ['code'=>200,'url'=>'/uploads/article/'.$filename];
        }
    }
    /**
     * 保存文章：
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            //参数验证：
            $this->validate($request,[
                'title'=>'required',
                'desn'=>'required',
                'content'=>'required'
            ]);
            //入库：使用修改器控制pic
            Article::create($request->all());
            return ['code'=>200,'msg'=>'添加成功'];
        }catch (\Exception $exception){
            return ['code'=>200,'msg'=>'添加失败'];
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * 文章修改页面：
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {

        return view('admin.article.edit',compact('article'));
    }

    /**
     * 更新文章：
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        try{
            //参数验证：
            $this->validate($request,[
                'title'=>'required',
                'desn'=>'required',
                'content'=>'required'
            ]);
            //入库：使用修改器控制pic
            //要更新图片，则删除原图片：
            if($article->pic!=config('up.default') && $article->pic!=$request->get('pic')){
                if(is_file(public_path($article->pic))){
                    unlink(public_path($article->pic));
                }
            }else{
                unset($article->pic);
            }
            $article->update($request->except('action'));
            
            return ['code'=>200,'msg'=>'修改成功'];
        }catch (\Exception $exception){
            return ['code'=>200,'msg'=>'修改失败'.$exception->getMessage()];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}
