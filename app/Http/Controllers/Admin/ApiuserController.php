<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apiuser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiuserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Apiuser::paginate($this->pageSize);
        return view('admin.apiuser.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.apiuser.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //表单验证：
        $this->validate($request,[
            'username'=>'required|unique:apiusers,username',
            'password'=>'required'
        ]);

        //使用ORM或者修改器将密码加密：bcrypt
        Apiuser::create($request->except('_token'));
        return redirect(route('admin.apiuser.index'))->with('success','添加成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apiuser  $apiuser
     * @return \Illuminate\Http\Response
     */
    public function show(Apiuser $apiuser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apiuser  $apiuser
     * @return \Illuminate\Http\Response
     */
    public function edit(Apiuser $apiuser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apiuser  $apiuser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apiuser $apiuser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apiuser  $apiuser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apiuser $apiuser)
    {
        //
    }
}
