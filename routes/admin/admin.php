<?php

//prefix表示地址前缀，namespance表示命名空间名称，as表示路由别名前缀
Route::group(['prefix'=>'admin','namespace'=>'Admin','as'=>'admin.'],function(){
    //用户登录页面和功能：
    Route::get('logout','LoginController@logout')->name('logout');
    Route::any('login','LoginController@index')->name('login');
    //退出登录：

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

        //定义分配角色权限页面路由：传入{role}，就相当于传入了该角色id
        Route::get('role/node/{role}','RoleController@showNode')->name('role.node');
        //定义分配角色权限功能路由：
        Route::post('role/node/{role}','RoleController@storeNode')->name('role.node');

        //定义权限资源路由：xxx/node/xxx
        Route::resource('node','NodeController');

        //用户分配角色页面：
        Route::get('user/role/{id}','UserController@role')->name('user.role');
        Route::post('user/role/{id}','UserController@storeRole')->name('user.role');

        //上传文件：
        Route::post('upfile','ArticleController@upfile')->name('article.upfile');
        //创建文章资源路由：admin/article/xxx
        Route::resource('article','ArticleController');


        //上传文件：
        Route::post('upfiles','FangAttrController@upfile')->name('fangattr.upfile');
        //定义房源属性资源路由：admin/fangattr/xxx
        Route::resource('fangattr','FangAttrController');


        //上传图片：
        Route::post('up_file','FangOwnerController@upfile')->name('fangowner.up_file');
        //移除已上传的图片：
        Route::delete('del_file','FangOwnerController@delfile')->name('fangowner.del_file');
        //查看身份证照片：
        Route::get('card_photo','FangOwnerController@show')->name('fangowner.show');

        //导出excel:
        Route::get('exports','FangOwnerController@exports')->name('fangowner.exports');
        //定义房东资源路由：
        Route::resource('fangowner','FangOwnerController');




        //改变房屋出租状态：
        Route::put('stat','FangController@stat')->name('fang.stat');
        //创建ElasticSearch索引
        Route::get('fang/es/init','FangController@esinit')->name('fang.esinit');
        //上传图片：
        Route::post('upfile','FangController@upfile')->name('fang.upfile');
        //移除已上传的图片：
        Route::delete('delfile','FangController@delfile')->name('fang.delfile');
        //获取市县数据：
        Route::get('city','FangController@city')->name('fang.city');
        //定义房源资源路由：
        Route::resource('fang','FangController');


        //定义预约资源路由：
        Route::resource('notice','NoticeController');

        //定义接口账号路由：
        Route::resource('apiuser','ApiuserController');
    });
});