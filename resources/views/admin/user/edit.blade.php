@extends('admin.common.main')

@section('css')

@endsection

@section('cnt')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户管理 <span class="c-gray en">&gt;</span> 用户详情 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

    <article class="page-container" style="margin: 0 auto">
        @include('admin.common.error')
        <form action="{{route('admin.user.update',['id'=>$user->id])}}" method="post" class="form form-horizontal" id="form-user-add">
            <!--模拟表单put提交-->
            {{method_field('PUT')}}
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>账号：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$user->username}}"  id="username" name="username" {{old('username')}}>
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>姓名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$user->truename}}" placeholder="请输入姓名" id="truename" name="truename" {{old('truename')}}>
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    @if($user->gender=='先生')
                        <div class="radio-box">
                            <input name="gender" type="radio" id="sex-1" value="先生" checked>
                            <label for="sex-1">先生</label>
                        </div>
                        <div class="radio-box">
                            <input type="radio" id="sex-2"  value="女士" name="gender" >
                            <label for="sex-2">女士</label>
                        </div>
                    @else
                        <div class="radio-box">
                            <input name="gender" type="radio" id="sex-1" value="先生">
                            <label for="sex-1">先生</label>
                        </div>
                        <div class="radio-box">
                            <input name="gender" type="radio" id="sex-1" value="女士" checked>
                            <label for="sex-1">女士</label>
                        </div>
                    @endif


                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机号：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$user->mobile}}" id="mobile" name="mobile" {{old('mobile')}}>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$user->email}}"name="email" id="email" {{old('email')}}>
                </div>
            </div>



            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交修改&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>
@endsection

@section('js')
    <script>
        //按钮样式：
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
    </script>
    <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/lib/jquery.js"></script>
    <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/jquery.validate.min.js"></script>

    <script>
        $(function(){
           $('#form-user-add').validate({
                rules:{
                    username:{
                        required:true
                    },
                    truename:{
                        required:true
                    },
                    mobile:{
                        required:true
                    },
                    email:{
                        email:true
                    }
                },
               messages:{
                   username:{
                        required: '账号必填'
                    },
                   truename:{
                       required: '姓名必填'
                   },
                   mobile:{
                       required:'手机号必填'
                   },
                   email:{
                       email:'请输入正确的电子邮箱'
                   }
               }
           });
        });
    </script>
@endsection