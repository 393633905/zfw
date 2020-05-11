<?php

namespace App\Models\Traits;

trait Btn
{
    /**
     * 用于根据权限显示按钮：
     * @param $route_name 要跳转的路由别名
     * @param string $name 按钮名称
     * @return string
     */
    public function btn($route_name,string $name){
        if($nodes=session('user_node')){
            if(auth()->user()->username==config('rbac.super_admin') || in_array($route_name,$nodes)){
                switch ($name){
                    case '修改':
                        return '<a href="'.route($route_name,$this).'" class="label label-warning radius">修改</a>';
                        break;
                    case '删除':
                        return '<a href="'.route($route_name,$this).'" class="label label-danger radius del">删除</a>';
                        break;
                    case '分配角色':
                        return '<a href="'.route('admin.user.role',$this).'" class="label label-secondary radius">分配角色</a>';
                        break;
                    case '分配权限':
                        return '<a href="'.route('admin.role.node',$this).'" class="label label-secondary radius">分配权限</a>';
                        break;
                }
            }
        }

    }
}