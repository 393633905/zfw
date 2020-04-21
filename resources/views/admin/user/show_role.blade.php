@extends('admin.common.main')
@section('css')
    <link rel="stylesheet" type="text/css" href="/css/pagination.css"/>
@section('cnt')
    @include('admin.common.success')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户管理
        <span class="c-gray en">&gt;</span> 角色分配 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="pd-30">
        <form action="{{route('admin.user.role',['id'=>$id])}}" method="post">
            {{csrf_field()}}
            @foreach($roles as $v)
                <input type="radio" name="role_id" value="{{$v['id']}}"
                       @if($v['id']==$role_id) checked @endif>{{$v['name']}}<br>
            @endforeach
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius submit" type="submit" value="&nbsp;&nbsp;确认分配角色&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </div>