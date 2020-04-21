@extends('admin.common.main')

@section('css')

@endsection

@section('cnt')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 权限管理 <span class="c-gray en">&gt;</span> 权限添加 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

    <article class="page-container" style="margin: 0 auto">
        @include('admin.common.error')
        <form action="{{route('admin.node.store')}}" method="post" class="form form-horizontal" @submit.prevent="doPost">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>是否顶级：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box">
                        <select class="select" @change="changePid">
                            <option value="0"> ---- 顶级菜单 ---- </option>
                            @foreach($nodes as $v)
                                <option value="{{$v['id']}}">{{$v['level_html']}} {{$v['name']}}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" placeholder="请输入权限名称"  name="name" v-model.lazy="node.name">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">路由别名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" placeholder="路由别名" name="route_name" v-model.lazy="node.route_name">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>是否菜单：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <input name="is_menu" type="radio" value="1" v-model="node.is_menu" checked>
                        <label for="is_menu-1">是</label>
                    </div>
                    <div class="radio-box">
                        <input name="is_menu" type="radio" value="0"  v-model="node.is_menu">
                        <label for="is_menu-2">否</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="添加权限">
                </div>
            </div>
        </form>
    </article>
@endsection

@section('js')
    <script src="/js/vue.js"></script>
    <script>
        const app=new Vue({
            el:'.page-container',
            data:{
                node:{
                    _token: "{{ csrf_token() }}",
                    pid:0,
                    name:'',
                    route_name:'',
                    is_menu:1,
                }
            },
            methods:{
                async doPost(evt){
                    let url=evt.target.action;
                    let {code,msg}=await $.post(url,this.node);
                    if(code==200){
                        layer.msg(msg,{icon:1,time:1000});
                    }else{
                        layer.msg(msg,{icon:2,time:1000});
                    }
                },
                changePid(evt){
                    this.node.pid=evt.target.value||0;
                }
            }
        });
    </script>
@endsection