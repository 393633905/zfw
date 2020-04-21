@extends('admin.common.main')

@section('css')
    {{-- webuploader上传样式 --}}
    <link rel="stylesheet" type="text/css" href="/plugins/webuploader/webuploader.css"/>
@endsection
@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 文章管理
        <span class="c-gray en">&gt;</span> 添加文章
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <article class="page-container">
        {{-- 表单验证提示 --}}
        @include('admin.common.error')
        <form action="{{ route('admin.article.store') }}" method="post" class="form form-horizontal" @submit.prevent="addArticle">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>文章标题：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="title" v-model.lazy="article.title">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>文章描述：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="desn" v-model.lazy="article.desn">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">文章封面：</label>
                <div class="formControls col-xs-4 col-sm-2">
                    <!-- 表单提交时的封面地址 -->
                    <div id="picker">上传文章封面</div>
                    <input type="hidden" name="pic" id="pic" v-model="article.pic">
                </div>
                <div class="formControls col-xs-4 col-sm-7">
                    <img src="{{config('up.default')}}" id="img" style="width: 100px; height: 80px">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>文章内容：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea name="content" id="content" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="添加文章">
                </div>
            </div>
        </form>
    </article>
@endsection
@section('js')
    <!--vue-->
    <script src="/js/vue.js"></script>
    <!-- ueditor配置文件 -->
    <script type="text/javascript" src="/plugins/ueditor/ueditor.config.js"></script>
    <!-- ueditor编辑器源码文件 -->
    <script type="text/javascript" src="/plugins/ueditor/ueditor.all.js"></script>
    <!-- webuploader上传js -->
    <script type="text/javascript" src="/plugins/webuploader/webuploader.js"></script>
    <!-- 实例化vue -->
    <script>
        var vue=new Vue({
            el:'.page-container',
            data:{
                article:{
                    title:'',//文章标题
                    desn:'',//文章摘要
                    pic:'',//文章封面图片
                    content:''//文章内容
                }
            },
            mounted(){
                //实例化ueditor:
                this.ue = UE.getEditor('content');
                this.ue.addListener('ready',()=>{//实例化完毕时，设置ueditor内容
                    this.ue.setContent(this.article.content);
                });
                //实例化WebUploader：
                this.uploader = WebUploader.create({
                    //开启自动上传
                    auto:true,
                    // swf文件路径
                    swf:'/plugins/webuploader/Uploader.swf',
                    // 文件接收服务端。
                    server: '{{route('admin.article.upfile')}}',
                    // 选择文件的按钮。可选。
                    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                    pick:{
                        id:'#picker',
                        multiple:false//关闭多文件上传
                    },
                    // 压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
                    resize: true,
                    accept: {//只允许上传图片
                        title: 'Images',
                        extensions: 'gif,jpg,jpeg,bmp,png',
                        mimeTypes: 'image/*'
                    },
                    formData:{
                        '_token':'{{csrf_token()}}'
                    }
                });
                //上传成功回调：
                //1.将图片url存入隐藏表单中
                //2.将上传的图片进行显示在旁边
                this.uploader.on('uploadSuccess',(file,response)=>{
                    this.article.pic=response.url?response.url:"{{config('up.default')}}";
                    //$('#pic').val(response.url);
                    $('#img').attr('src',response.url);
                });
            },
            methods:{
                async addArticle(evt){//发送请求添加文章
                    this.article.content=this.ue.getContent();
                    let body=JSON.stringify(this.article);
                    let ret=await fetch(evt.target.action,{
                      method:'POST',
                      headers:{
                          'X-CSRF-TOKEN':'{{csrf_token()}}',
                          'Content-Type':'application/json'
                      },
                        body:body
                    });
                    let json=await ret.json();
                    if(json.code==200){
                        //添加成功：
                        layer.msg(json.msg,{icon:1,time:1000});
                    }else{
                        layer.msg(json.msg,{icon:2,time:1000});
                    }
                }
            }
        });
    </script>
@endsection

