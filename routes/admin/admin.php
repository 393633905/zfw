<?php

//prefix表示地址前缀，namespance表示命名空间名称，as表示路由别名前缀
Route::group(['prefix'=>'admin','namespace'=>'Admin','as'=>'admin.'],function(){
    //用户登录页面和功能：
    Route::any('login','LoginController@index')->name('login');
    //退出登录：
    Route::get('logout','LoginController@logout')->name('logout');

    //绑定中间件：
    //使用中间件验证用户是否登录：
    Route::group(['middleware'=>'check_login'],function(){
        //显示首页：
        Route::get('index','IndexController@index')->name('index');
        //显示首页子页面：
        Route::get('welcome','IndexController@welcome')->name('welcome');
        //显示用户列表：
        Route::get('user/index','UserController@index')->name('user.index');

        //显示添加用户页面：
        Route::get('user/create','UserController@create')->name('user.create');
        //添加用户功能：
        Route::post('user/save','UserController@save')->name('user.save');

        //删除用户功能：
        Route::delete('user/delete/{id}','UserController@delete')->name('user.delete');
        //删除所有用户：
        Route::delete('user/delall','UserController@deleteAll')->name('user.delall');

        //用户回收站页面显示：
        Route::get('user/restore','UserController@restore')->name('user.restore');
        //用户还原：
        Route::get('user/rollback/{id}','UserController@rollback')->name('user.rollback');
        //还原所有用户：
        Route::put('user/rollbackAll','UserController@rollbackAll')->name('user.rollbackAll');

        //显示修改用户详情页面：
        Route::get('user/edit/{id}','UserController@edit')->name('user.edit');
        //修改用户功能：
        Route::put('user/update/{id}','UserController@update')->name('user.update');

        //定义角色资源路由：xxx/role/xxx
        Route::resource('role','RoleController');
        //定义权限资源路由：xxx/node/xxx
        Route::resource('node','NodeController');
    });
});