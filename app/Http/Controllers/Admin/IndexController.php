<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fang;
use App\Models\Node;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(){
        if(!auth()->check()){
            return redirect(route('admin.login'));
        }

        //已经登录：
        //显示菜单列表：通过session获取该用户拥有的权限，然后显示即可；
        if(session('user_node')){
            $menus=(new Node())->getUserMenuData(session('user_node'));
        }

        return view('admin/index/index',compact('menus'));
    }

    public function welcome(){
        $data=(new Fang())->getRentData();
        return view('admin/index/welcome',$data);
    }
}
