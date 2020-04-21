@extends('admin.common.main')


@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房源属性管理
        <span class="c-gray en">&gt;</span> 房源属性列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    {{-- 消息提示 --}}
    @include('admin.common.success')

    <div class="page-container">
        <form method="get" class="text-c"> 输入想要搜索的房源属性名称：
            <input type="text" class="input-text" style="width:250px" placeholder="房源属性" value="{{ request()->get('name') }}" name="name" autocomplete="off">
            <button type="submit" class="btn btn-success radius"><i class="Hui-iconfont">&#xe665;</i> 搜房源属性</button>
        </form>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="{{ route('admin.fangattr.create') }}" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加房源属性
            </a>
        </span>
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="100">房源属性名称</th>
                    <th width="100">图标</th>
                    <th width="100">字段名称</th>
                    <th width="130">加入时间</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                    <tr class="text-c">
                        <td>{{ $item['id'] }}</td>
                        <td class="text-l">
                           {{$item['level_html']}} {{ $item['name'] }}
                        </td>
                        <td><img src="{{ $item['icon'] }}" style="width: 50px;"/></td>
                        <td>{{ $item['field_name'] }}</td>
                        <td>{{ $item['created_at'] }}</td>
                        <td class="td-manage">
                            {!! \App\Models\FangAttr::find($item['id'])->btn('admin.fangattr.edit','修改') !!}
                            {!! \App\Models\FangAttr::find($item['id'])->btn('admin.fangattr.destroy','删除') !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <!--请在下方写此页面业务相关的脚本-->
    <script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>
    <script>
        //删除:发送Delete请求
        $(function(){
           let _token="{{csrf_token()}}";

           $('.del').click(function(){
               let url=$(this).attr('href');
               $.ajax({
                    url,
                    type:'delete',
                    data:{_token},
                }).then((ret) => {
                   if (ret.code == 200) {  //删除成功
                       layer.msg('删除成功', {icon: 1,time:1000},()=>{
                           $(this).parents('tr').remove();
                       });
                   }
               });;
               return false;//禁止默认事件
           });
        });
    </script>
@endsection
