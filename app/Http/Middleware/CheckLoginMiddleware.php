<?php

namespace App\Http\Middleware;

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
        return $next($request);
    }
}
