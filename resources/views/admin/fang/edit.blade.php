@extends('admin.common.main')

@section('css')
    {{-- webuploader上传样式 --}}
    <link rel="stylesheet" type="text/css" href="/plugins/webuploader/webuploader.css"/>
@endsection

@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房源管理
        <span class="c-gray en">&gt;</span> 修改房源
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <article class="page-container">
        {{-- 表单验证提示 --}}
        @include('admin.common.error')

        <form action="{{ route('admin.fang.update',$fang) }}"  method="post" class="form form-horizontal" id="fang-add">
            {{method_field('PUT')}}
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>房源名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="fang_name" value="{{$fang->fang_name}}" >
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>小区名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="fang_xiaoqu" value="{{$fang->fang_xiaoqu}}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>小区地址：</label>
                <div class="formControls col-xs-4 col-sm-4">
                    <select name="fang_province" style="width: 100px;" onchange="cityChange(this,'city')">
                        <option value="0">==请选择省==</option>
                        @foreach($cityData as $item)
                            <option value="{{ $item->id }}" @if($item->id==$fang->fang_province) selected @endif>{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <select name="fang_city" id="fang_city" style="width: 100px;" onchange="cityChange(this,'area')">
                        <option value="0">==请选择市==</option>
                        @foreach($city as $item)
                            <option value="{{ $item->id }}" @if($item->id==$fang->fang_city) selected @endif>{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <select name="fang_region" id="fang_region" style="width: 100px;">
                        <option value="0">==区/县==</option>
                        @foreach($region as $item)
                            <option value="{{ $item->id }}" @if($item->id==$fang->fang_region) selected @endif>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="formControls col-xs-4 col-sm-5">
                    <input type="text" class="input-text" name="fang_addr" placeholder="小区详情地址和房源说明" value="{{$fang->fang_addr}}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>租金：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" style="width: 200px;" name="fang_rent" value="{{$fang->fang_rent}}"> 元
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>楼层：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" style="width: 200px;" name="fang_floor" value="{{$fang->fang_floor}}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>租期方式：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select name="fang_rent_type" style="width: 200px;">
                        @foreach($fang_rent_type_data as $item)
                            <option value="{{ $item->id }}" @if($fang->fang_rent_type==$item->id)selected @endif>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>几室：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="fang_shi" value="{{$fang->fang_shi}}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>几厅：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="fang_ting" value="{{$fang->fang_ting}}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>几卫：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="fang_wei" value="{{$fang->fang_wei}}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>朝向：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select name="fang_direction" style="width: 200px;">
                        @foreach($fang_direction_data as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>租赁方式：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select name="fang_rent_class" style="width: 200px;">
                        @foreach($fang_rent_class_data as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>建筑面积：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="fang_build_area" value="{{$fang->fang_build_area}}" style="width: 60px;">平米
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>使用面积：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="fang_using_area" value="{{$fang->fang_using_area}}" style="width: 60px;">平米
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>建筑年代：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" onfocus="WdatePicker({dateFmt:'yyyy'})" name="fang_year" class="input-text Wdate"
                           style="width:120px;"  value="{{$fang->fang_year}}" >
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>配套设施：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    @foreach($fang_config_data as $item)
                        <label>
                            <input type="checkbox" name="fang_config[]" value="{{ $item->id }}" @if(in_array($item->id,$fang->fang_config)) checked @endif/>
                            {{ $item->name }} &nbsp;&nbsp;
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>房屋图片：</label>
                <div class="formControls col-xs-2 col-sm-2">
                    <div id="picker">房屋图片</div>
                </div>
                <div class="formControls col-xs-6 col-sm-7">
                    <!-- 表单提交时，上传图片地址，以#隔开 -->
                    <input type="hidden" name="fang_pic" id="fang_pic" value="{{$fang->fang_pic}}"/>
                    <!-- 显示上传成功后的图片容器 -->
                    <div id="imglist">
                        @foreach($fang->changeFangPicToArray() as $item)
                            <div style="width: 120px;height: 90px;float: left;margin: 2px;position: relative">
                                <img src="{{$item}}" style="width: 120px;height: 90px;;position: absolute">
                                <strong style="position: absolute;color: black;font-size: 16px;right: 3px;top:2px;cursor: pointer;" id="remove" onclick="remove(this,'{{$item}}')">X</strong>
                            </div>

                            @endforeach
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>房东：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select name="fang_owner" style="width: 200px;">
                        @foreach($ownerData as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>是否推荐：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <label>
                            <input name="is_recommend" type="radio" value="0" @if($fang->is_recommend == 0) checked @endif>
                            否
                        </label>
                    </div>
                    <div class="radio-box">
                        <label>
                            <input type="radio" value="1" name="is_recommend" @if($fang->is_recommend == 1) checked @endif>
                            是
                        </label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>房屋描述：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea name="fang_desn" class="form-control textarea">{{ $fang->fang_desn}}</textarea>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>房屋详情：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea id="fang_body" name="fang_body">{{ $fang->fang_body}}</textarea>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="修改房源">
                </div>
            </div>
        </form>
    </article>
@endsection

@section('js')
    <!-- webuploader上传js -->
    <script type="text/javascript" src="/plugins/webuploader/webuploader.js"></script>

    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
    <!-- 配置文件 -->
    <script type="text/javascript" src="/plugins/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/plugins/ueditor/ueditor.all.js"></script>

    <script>
        //省市区三级联动：
        //1.当省选择框触发change事件，根据省的id找到市数据
        function cityChange(obj, select_name) {
            let province_id = $(obj).val();//省份id;
            //发送ajax请求，后端根据省id找到市数据，然后将数据设置到市选择框中
            $.get('{{route('admin.fang.city')}}', {id: province_id}).then((ret) => {
                if (select_name == 'city') {
                    if (ret.code == 200) {
                        let option_html = '<option value="0">==请选择市==</option>';
                        ret.data.map((item) => {
                            option_html += `<option value='${item.id}'>${item.name}</option>`;
                        });
                        $('#fang_city').html(option_html);
                    }
                } else {
                    if (ret.code == 200) {
                        let option_html = '<option value="0">==县/区==</option>';
                        ret.data.map((item) => {
                            option_html += `<option value='${item.id}'>${item.name}</option>`;
                        });
                        $('#fang_region').html(option_html);
                    }
                }
            });
        }

        // 富文本编辑器
        var ue = UE.getEditor('fang_body', {
            initialFrameHeight: 200
        });

        // 初始化Web Uploader
        var uploader = WebUploader.create({
            // 选完文件后，是否自动上传
            auto: true,
            // swf文件路径
            swf: '/plugins/webuploader/Uploader.swf',
            // 文件接收服务端 上传PHP的代码
            server: '{{ route('admin.fang.upfile') }}',
            // 文件上传是携带参数
            formData: {
                _token: '{{csrf_token()}}'
            },
            // 文件上传是的表单名称
            fileVal: 'file',
            fileNumLimit:3,//上传数量限制
            // 选择文件的按钮
            pick: {
                id: '#picker',
                // 是否开启选择多个文件的能力
                multiple: true
            },
            // 压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: true
        });
        // 上传成功时的回调方法：response为响应数据集
        uploader.on('uploadSuccess', function (file, response){
            //1.添加图片显示：
            let img=`
<div style="position: relative;width: 120px;height: 90px;float: left;margin: 2px">
    <img src=${response.url} style='width: 120px;height: 90px;' /> &nbsp;
    <strong style="position: absolute;color: black;font-size: 16px;right: 3px;top:2px;cursor: pointer;" id="remove" onclick="remove(this,'${response.url}')">X</strong>
</div>`;
            $('#imglist').append(img);

            //2.将多张图片的url,经过分隔处理存入到隐藏表单中以便于入库：
            let pic=$('#fang_pic');
            let temp=pic.val();
            temp+=response.url+"#";
            pic.val(temp);
        });

        //点击X后删除整行div和隐藏域中的链接
        async function remove(obj,url){
            //发送请求移除图片：
            let removeUrl="{{route('admin.fang.delfile')}}";
            let _token="{{csrf_token()}}";
            let ret=await $.ajax({
                url:removeUrl,
                type:'delete',
                data:{
                    url,_token
                },
            });
            if(ret.code==200){
                //替换隐藏域中链接：
                $('#fang_pic').val($('#fang_pic').val().replace(url+'#',''));
                //删除整行：
                $(obj).parent('div').remove();
            }
        }

        // 前端表单验证
        $("#fang-add").validate({
            // 规则
            rules: {
                fang_name: {
                    required: true
                },
                fang_province: {
                    min: 1
                },
                fang_city: {
                    min: 1
                },
                fang_region: {
                    min: 1
                },
                fang_addr: {
                    required: true
                },
                fang_rent: {
                    number: true
                },
                fang_floor: {
                    number: true
                },
                fang_year: {
                    required: true
                },
                fang_desn: {
                    required: true
                }
            },
            messages: {
                fang_province: {
                    min: '省份不能为空'
                },
                fang_city: {
                    min: '市不能为空'
                },
                fang_region: {
                    min: '区或县不能为空'
                }
            },
            // 取消键盘事件
            onkeyup: false,
            // 验证成功后的样式
            success: "valid",
            // 验证通过后，处理的方法 form dom对象
            submitHandler: function (form) {
                // 表单提交
                form.submit();
            }
        });
    </script>

@endsection

