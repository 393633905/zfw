@extends('admin.common.main')

@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 文章管理
        <span class="c-gray en">&gt;</span> 文章列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    {{-- 消息提示 --}}
    <div class="page-container">
        <form method="get" class="text-c" id="form">
            <input type="text" id="datemin" class="input-text Wdate" style="width:120px;" placeholder="格式：例2020-04-12">
            -
            <input type="text" id="datemax" class="input-text Wdate" style="width:120px;" placeholder="格式：例2020-04-12">
            文章标题：
            <input type="text" class="input-text" style="width:250px" placeholder="文章标题" value="{{ request()->get('title') }}" id="title" autocomplete="off">
            <button type="submit" class="btn btn-success radius"><i class="Hui-iconfont">&#xe665;</i> 搜索文章</button>
        </form>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="{{ route('admin.article.create') }}" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加文章
            </a>
        </span>
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort" id="article_table">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="100">文章标题</th>
                    <th width="60">加入时间</th>
                    <th width="120">操作</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript" charset="utf8" src="http://cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            var table=$('#article_table').DataTable({
                language:{
                    "sProcessing": "处理中...",
                    "sLengthMenu": "显示 _MENU_ 项结果",
                    "sZeroRecords": "没有匹配结果",
                    "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                    "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                    "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                    "sInfoPostFix": "",
                    "sSearch": "搜索:",
                    "sUrl": "",
                    "sEmptyTable": "表中数据为空",
                    "sLoadingRecords": "载入中...",
                    "sInfoThousands": ",",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "上页",
                        "sNext": "下页",
                        "sLast": "末页"
                    },
                    "oAria": {
                        "sSortAscending": ": 以升序排列此列",
                        "sSortDescending": ": 以降序排列此列"
                    }
                },//本地化
                searching: false,//关闭本地搜索框
                serverSide: true,//开启服务器模式，
                ajax:{//发送ajax请求
                    type:'get',
                    url:"{{route('admin.article.index')}}",
                    data:function(ret){//使用函数动态获取表单中的参数值进行传递：
                        ret.datemax=$('#datemax').val();
                        ret.datemin=$('#datemin').val();
                        ret.title=$.trim($('#title').val());
                    }
                },
                columns: [
                        // 总的数量与表格的列的数量一致，不多也不少
                        // 字段名称与sql查询出来的字段时要保持一致，就是服务器返回数据对应的字段名称
                        // defaultContent 和 className 可选参数
                    {'data':'id'},
                    {'data':'title'},
                    {'data':'created_at'},
                    {'data':'action','defaultContent': '默认值'},
                ],
            });

            $('#form').submit(function(){//文章搜索
                table.ajax.reload();//刷新
                return false;//阻止表单默认提交
            });
        } );
    </script>
@endsection
