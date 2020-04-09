@extends('admin.common.main')

@section('css')

@endsection

@section('cnt')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 角色管理 <span class="c-gray en">&gt;</span> 角色修改 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

    <article class="page-container" style="margin: 0 auto">
        @include('admin.common.error')
        <!--因更新要传入id,但是laravel可以直接精简传递对象过去，底层自动find($id)-->
        <form action="{{route('admin.role.update',$role)}}" method="post" class="form form-horizontal" id="form-role-add">
            {{method_field('put')}}
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text"  placeholder="请输入角色名称" id="name" autocomplete="false" name="name" value="{{$role->name}}" >
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius submit" type="submit" value="&nbsp;&nbsp;确认修改&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>
@endsection

@section('js')
    <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/lib/jquery.js"></script>
    <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/jquery.validate.min.js"></script>

    <script>
        $(function(){
            //表单验证：
           $('#form-role-add').validate({
                rules:{
                    name:{
                        required:true
                    },
                },
               messages:{
                   name:{
                       required:'角色名称必填'
                   }
               },
               submitHandler:function(form){
                    let url=$(form).attr('action');
                    let data=$(form).serialize();
                    $.ajax({
                        url,
                        type:'put',
                        data,
                        dataType:'json'
                    }).then((ret)=>{
                        let {code,msg}=ret;
                        if(code==200){
                            layer.msg(msg,{icon:1,time:2000});
                            window.location="{{route('admin.role.index')}}";
                        }else{
                            layer.msg(msg,{icon:2,time:1000});
                        }
                    })
                }
           });
        });
    </script>
@endsection