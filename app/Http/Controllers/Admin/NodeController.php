<?php

namespace App\Http\Controllers\Admin;

use App\Models\Node;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NodeController extends Controller
{
    /**
     * 权限列表：
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nodes=(new Node)->getNodeCateList();
        return view('admin.node.index',compact('nodes'));
    }

    /**
     * 添加权限页面：
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nodes=(new Node)->getNodeCateList();
        return view('admin.node.create',compact('nodes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            //参数检测：
            $rule=[
                'name'=>'required',
                'is_menu'=>'required',
                'pid'=>'required'
            ];
            $this->validate($request,$rule);

            //入库：
            Node::create($request->except('_token'));

            return ['code'=>200,'msg'=>'添加权限成功'];
        }catch (\Exception $exception){
            return ['code'=>500,'msg'=>'提交内容不合法'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function show(Node $node)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function edit(Node $node)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Node $node)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function destroy(Node $node)
    {
        //
    }
}
