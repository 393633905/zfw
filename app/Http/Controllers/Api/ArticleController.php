<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Api\Article;
use App\Models\Api\ArticleCount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends BaseController
{
    public function get(Request $request){
        try{
            $field=[
                'id','title','desn','pic'
            ];
            $article_model=Article::orderBy('id','desc')->select($field)->paginate($this->pageSize);
            return response()->json(['status'=>200,'msg'=>'获取成功','data'=>$article_model]);
        }catch (\Exception $exception){
            return response()->json(['status'=>10000,'msg'=>'请求参数错误'],401);
        }
    }

    public function getItem(Article $article){
        return response()->json(['status'=>200,'msg'=>'获取成功','data'=>$article]);
    }

    //文章记录：
    public function count(Request $request,int $article_id){
        try{
            $data=[
                'openid'=>$request->get('openid'),
                'art_id'=>$article_id,
                'vdt'=>date('Y-m-d'),
                'vtime'=>time()
            ];
            ArticleCount::create($data);
            return response()->json(['status'=>200,'msg'=>'记录成功']);
        }catch (\Exception $exception){
        }
    }
}
