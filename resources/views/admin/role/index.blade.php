
@extends('admin.common.main')
@section('css')
    <link rel="stylesheet" type="text/css" href="/css/pagination.css" />
@section('cnt')
    @include('admin.common.success')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 角色管理 <span class="c-gray en">&gt;</span> 角色列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
    <form class="text-c" method="get" action="{{route('admin.role.index')}}"> 角色搜索：
        <input type="text" class="input-text" style="width:250px" placeholder="输入角色名称"  name="name" value="{{request()->get('name')}}">
        <button type="submit" class="btn btn-success" id="" name=""><i class="icon-search"></i> 搜角色</button>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="{{ route('admin.role.create') }}" class="btn btn-primary radius"><i class="icon-plus"></i> 添加角色</a>
        </span>
        <span class="r">共有数据：<strong>{{$roles->total()}}</strong> 条</span>
    </div>

    <table class="table table-border table-bordered table-hover table-bg table-sort">
        <thead>
        <tr class="text-c">
            <th width="25"><input type="checkbox" name="" value=""></th>
            <th width="80">ID</th>
            <th width="200">角色名</th>
            <th width="100">加入时间</th>
            <th width="70">状态</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $v)
        <tr class="text-c">
            <td><input type="checkbox" value="{{$v->id}}" name="id[]" ></td>
            <td>{{$v->id}}</td>
            <td>{{$v->name}}</td>
            <td>{{$v->created_at}}</td>
            <td class="user-status"><span class="label label-success">已启用</span></td>
            <td class="f-14 user-manage">
               {!! $v->btn('admin.role.node','分配权限') !!}
                <!--因laravel中传入id时，若是从对象中获取id，则可以直接传入该对象，省略id-->
                   {!! $v->btn('admin.role.edit','修改') !!}
                   {!! $v->btn('admin.role.destroy','删除') !!}
            </td>
        </tr>
            @endforeach
        </tbody>
    </table>
    <div id="pageNav" class="pageNav">
        {{$roles->render()}}
    </div>
</div>
@endsection

@section('js')
    <script>
        $(function () {
            const _token="{{csrf_token()}}";
             $('.del').click(function(){
                 layer.confirm('您真的要删除当前角色吗？', {
                     btn: ['确认','取消'] //按钮
                 }, ()=>{//确认
                     let url=$(this).attr('href');
                     //发送ajax delete请求：
                     $.ajax({
                         url,
                         type:'delete',
                         data:{_token},
                         dataType:'json',
                     }).then((ret)=>{
                         if(ret.code==200){  //删除成功
                             layer.msg('删除成功', {icon: 1});
                             $(this).parents('tr').remove();
                         }
                     });
                 });
                 //禁用a标签默认事件
                 return false;
             });
        });
    </script>
@endsection