<?php

namespace App\Http\Middleware;

use App\Models\Node;
use Closure;

class CheckLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //检测用户是否登录：
        if(!auth()->check()){//未登录
            //跳转到登录页面：
            return redirect(route('admin.login'))->withErrors('请登录');
        }

        //用户登录成功：
        //1.使用关联模型获取该用户所拥有的权限的id,并使用session存储；
        $user_model=auth()->user();//获取user模型
        if($user_model->username==config('rbac.super_admin')){
            //如果是超级管理员，则直接存放所有权限：
            $nodes=Node::all()->pluck('route_name','id')->toArray();
        }else{
            $role_model=$user_model->role;//$user_model->role()->get();
            $nodes=$role_model->nodes()->pluck('route_name','id')->toArray();//该用户所拥有的权限id和路由名称
        }
        session(['user_node'=>$nodes]);


        //2.判断用户此次请求是否有权限：
        $route_name=$request->route()->getName();
        //因有些权限无route_name，故需排除。
        $nodes=array_merge(array_filter($nodes),config('rbac.no_check'));
        //判断当前路由别名是否在权限中，若不在再判断是否是超管，若不是则直接提示无权限
        if(!in_array($route_name,$nodes) && $user_model->username!=config('rbac.super_admin')){
          exit('您无权限');
        }
        return $next($request);
    }
}
