<?php

Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    //用户登录页面和功能：
    Route::any('login','LoginController@index')->name('admin.login');
    //退出登录：
    Route::get('logout','LoginController@logout')->name('admin.logout');

    //绑定中间件：
    //使用中间件验证用户是否登录：
    Route::group(['middleware'=>'check_login'],function(){
        //显示首页：
        Route::get('index','IndexController@index')->name('admin.index');
        //显示首页子页面：
        Route::get('welcome','IndexController@welcome')->name('admin.welcome');
        //显示用户列表：
        Route::get('user/index','UserController@index')->name('admin.user.index');

        //显示添加用户页面：
        Route::get('user/create','UserController@create')->name('admin.user.create');
        //添加用户功能：
        Route::post('user/save','UserController@save')->name('admin.user.save');

        //删除用户功能：
        Route::delete('user/delete/{id}','UserController@delete')->name('admin.user.delete');
        //删除所有用户：
        Route::delete('user/delall','UserController@deleteAll')->name('admin.user.delall');

        //用户回收站页面显示：
        Route::get('user/restore','UserController@restore')->name('admin.user.restore');
        //用户还原：
        Route::get('user/rollback/{id}','UserController@rollback')->name('admin.user.rollback');
        //还原所有用户：
        Route::put('user/rollbackAll','UserController@rollbackAll')->name('admin.user.rollbackAll');

        //显示修改用户详情页面：
        Route::get('user/edit/{id}','UserController@edit')->name('admin.user.edit');
        //修改用户功能：
        Route::put('user/update/{id}','UserController@update')->name('admin.user.update');
    });
});
