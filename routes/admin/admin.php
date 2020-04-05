<?php

Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    //用户登录页面和功能：
    Route::any('login','LoginController@index')->name('admin.login');
    //退出登录：
    Route::get('logout','LoginController@logout')->name('admin.logout');

    //显示首页：
    Route::get('index','IndexController@index')->name('admin.index');
    //显示首页子页面：
    Route::get('welcome','IndexController@welcome')->name('admin.welcome');

});
