
@extends('admin.common.main')
@section('css')
    <link rel="stylesheet" type="text/css" href="/css/pagination.css" />
@section('cnt')
    @include('admin.common.success')
    @include('admin.common.error')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 权限管理 <span class="c-gray en">&gt;</span> 权限列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
    <form class="text-c" method="get" action="{{route('admin.node.index')}}"> 权限搜索：
        <input type="text" class="input-text" style="width:250px" placeholder="输入权限名称"  name="name" value="{{request()->get('name')}}">
        <button type="submit" class="btn btn-success" id="" name=""><i class="icon-search"></i> 搜权限</button>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="{{ route('admin.node.create') }}" class="btn btn-primary radius"><i class="icon-plus"></i> 添加权限</a>
        </span>
        <span class="r">共有数据：<strong>{{count($nodes)}}</strong> 条</span>
    </div>

    <table class="table table-border table-bordered table-hover table-bg table-sort">
        <thead>
        <tr class="text-c">
            <th width="25"><input type="checkbox" name="" value=""></th>
            <th width="80">ID</th>
            <th width="100">权限名</th>
            <th width="80">路由别名</th>
            <th width="100">是否菜单</th>
            <th width="130">加入时间</th>
            <th width="70">状态</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($nodes as $v)
        <tr class="text-c">
            <td><input type="checkbox" value="{{$v['id']}}" name="id[]" ></td>
            <td>{{$v['id']}}</td>
            <td class="text-l">{{$v['level_html']}} {{$v['name']}}</td>
            <td class="text-l">{{$v['route_name']}}</td>
            <td>
                @if($v['is_menu']==1)
                    <span class="label label-success">是</span>
                    @else
                    <span class="label label-danger">否</span>
                @endif
            </td>
            <td>{{$v['created_at']}}</td>
            <td class="user-status"><span class="label label-success">已启用</span></td>
            <td class="f-14 user-manage">
                <!--因laravel中传入id时，若是从对象中获取id，则可以直接传入该对象，省略id-->
                {!! \App\Models\Node::find($v['id'])->btn('admin.node.edit','修改') !!}
                @if($v['id'] !=auth()->id())
                    {!! \App\Models\Node::find($v['id'])->btn('admin.node.destroy','删除') !!}
                @endif
            </td>
        </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection

@section('js')
    <script>
        $(function () {
            const _token="{{csrf_token()}}";
             $('.del').click(function(){
                 layer.confirm('您真的要删除当前权限吗？', {
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