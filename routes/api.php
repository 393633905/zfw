<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


//接口登录：
Route::post('login','Api\LoginController@login');

//www.zfw.com/api/v1/
Route::group(['middleware'=>'auth:api','prefix'=>'v1','namespace'=>'Api'],function(){
    //微信登录：
    Route::get('wxlogin','LoginController@wxlogin');

    //授权获取用户信息：
    Route::get('user/get','UserController@get');

    //修改用户信息：
    Route::post('user/set','UserController@set');

    //身份证照片上传：
    Route::post('user/upload','UserController@upCardFile');

    //看房通知：
    Route::get('notice','NoticeController@get');

    //资讯列表：
    Route::get('article','ArticleController@get');
    //资讯列表详情：
    Route::get('article/{article}','ArticleController@getItem');
    //记录资讯读取记录：
    Route::post('article/{id}','ArticleController@count');

    //推荐房源：
    Route::get('fang/recommend','FangController@recommend');
    //所有房源信息：
    Route::get('fang/get','FangController@get');
    //房源小组：
    Route::get('fang/attr','FangController@attr');
    //获取指定房源信息：
    Route::get('fang/get/{fang}','FangController@item');
    //获取指定属性的房源数据
    Route::get('fang/attrfang','FangController@getAttrWithFang');

    //所有属性信息：
    Route::get('fangattr/get','FangAttrController@get');

    //es模糊搜索：
    Route::get('fang/es/search','FangController@esSearch');

    //查看房源收藏：
    Route::get('fang/collect/get','FangController@getCollect');
    //删除房源收藏：
    Route::delete('fang/collect/destroy','FangController@destroyCollect');
    //设置收藏：
    Route::post('fang/collect/set','FangController@setCollect');

});