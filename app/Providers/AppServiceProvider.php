<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //自定义验证：
        //第一个参数是自定义验证规则字段
        //第二个参数是回调函数，被验证的属性名称 $attribute、属性的值 $value、传入验证规则的参数数组 $parameters、及 Validator 实例
        Validator::extend('mobile', function ($attribute, $value, $parameters, $validator) {
            $reg1='/^\+86-1[3-9]\d{9}$/';
            $reg2='/^1[3-9]\d{9}$/';
            return preg_match($reg1,$value)||preg_match($reg2,$value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
