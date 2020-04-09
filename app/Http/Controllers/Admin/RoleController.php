<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;

class RoleController extends BaseController
{
    /**
     * 角色列表展示：
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name=$request->get('name');
        //使用when：若$name存在，则执行回调函数。若不存在则不执行回调函数
        $roles=Role::when($name,function($query) use($name){
            $query->where('name','like',"%{$name}%");
        })->paginate($this->pageSize);

        return view('admin.role.index',compact('roles'));
    }

    /**
     * 角色添加展示：
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * 存储角色功能：
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            //表单验证：
            $this->validate($request,[
               'name'=>'required|unique:roles,name'
            ]);
            //入库：
            Role::create($request->except('_token'));
            return ['code'=>200,'msg'=>'添加角色成功'];
        }catch (\Exception $exception){
            return ['code'=>500,'msg'=>'角色名称不合法'];
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * 角色修改显示页面：
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('admin.role.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        try{
            //表单验证：
            $name=$this->validate($request,[
                'name'=>'required|unique:roles,name,'.$role->id.',id'
            ]);
            //更新：
            if($role->update($name)){
                return ['code'=>200,'msg'=>'修改角色成功'];
            }
        }catch (\Exception $exception){
            return ['code'=>500,'msg'=>'角色名称不合法'];
        }
    }

    /**
     * 删除指定角色：
     *
     */
    public function destroy(Role $role)
    {
        $count=$role->delete();
        if($count){
            return ['code'=>200,'msg'=>'删除角色成功'];
        }
        return ['code'=>500,'msg'=>'error'];
    }
}
