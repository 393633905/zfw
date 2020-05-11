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


        //2.因每次请求都需判断用户此次请求是否有权限，故在中间件中进行判断：
        $route_name=$request->route()->getName();//获取此次访问的路由别名
        $nodes=session('user_node');
        //先判断当前请求的路由别名是否在未检测范围内，若不是再判断当前路由别名是否在权限中，若不在再判断是否是超管，若不是则直接提示无权限
        if(!in_array($route_name,config('rbac.no_check')) &&!in_array($route_name,$nodes) && auth()->user()->username!=config('rbac.super_admin')){
            exit('<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<article class="page-404 minWP text-c">
    <p class="error-title"><i class="Hui-iconfont va-m">&#xe688;</i>
        <span class="va-m"> 404</span>
    </p>
    <p class="error-description">不好意思，您访问的页面不存在~</p>
    <p class="error-info">您可以： <a href="javascript:;" onclick="history.go(-1)" class="c-primary">&lt; 返回上一页</a> <span class="ml-20">|</span></p>
</article>
</body>
</html>');
        }


        //请求允许
        return $next($request);
    }
}
