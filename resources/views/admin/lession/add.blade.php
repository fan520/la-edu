<!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    @include('admin.common.header')
    <title>添加课程 - 课程管理 </title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link href="http://cdn.bootcss.com/bootstrap/3.3.1/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
    <link href="{{ asset('common/vendor/webuploader/webuploader.css') }}" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="http://cdn.bootcss.com/jquery/1.9.1/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('common/vendor/webuploader/webuploader.css') }}">
    <script type="text/javascript" src="{{ asset('common/vendor/webuploader/webuploader.min.js') }}"></script>
    <script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

</head>
<body>

<article class="page-container">
    <form class="form form-horizontal" id="form-admin-add"  method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>课程名称：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <input type="text" class="input-text" value="" placeholder="" id="course_name" name="course_name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>所属专业：</label>
            <div class="formControls col-xs-8 col-sm-8"> <span class="select-box" style="width:150px;">
			<select class="select" name="profession_id" size="1">
               <option value="0">请选择</option>
				@foreach($profession as $v)
                    <option value="{{ $v->id }}"> {{ $v->pro_name }}</option>
                @endforeach
			</select>
			</span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">封面：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <div id="uploader-demo">
                    <!--用来存放item-->
                    <div id="fileList" class="uploader-list"></div>
                    <div id="filePicker">选择图片</div>
                </div>
                <input type="hidden" name="cover_img">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>排序：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <input type="text" class="input-text" value="1" placeholder="" id="sort" name="sort">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>状态：</label>
            <div class="formControls col-xs-8 col-sm-8 skin-minimal">
                <div class="radio-box">
                    <input name="status" type="radio"  value="1" checked>
                    <label for="sex-1">启用</label>
                </div>
                <div class="radio-box">
                    <input name="status" type="radio" value="2">
                    <label for="sex-1">禁用</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">描述：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <input type="text" class="input-text" value="" placeholder="" id="description" name="description">
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <input type="submit" value="添加" class="btn btn-secondary radius">
                <button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
    </form>
</article>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="{{asset('admin/lib/jquery/1.9.1/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/lib/layer/2.4/layer.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/static/h-ui/js/H-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/static/h-ui.admin/js/H-ui.admin.js')}}"></script> <!--/_footer /作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{asset('admin/lib/My97DatePicker/4.8/WdatePicker.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/lib/webuploader/0.1.5/webuploader.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/lib/ueditor/1.4.3/ueditor.config.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/lib/ueditor/1.4.3/ueditor.all.min.js')}}"> </script>
<script type="text/javascript" src="{{asset('admin/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js')}}"></script>
<script type="text/javascript">
    $(function () {
        // 初始化Web Uploader
        var uploader = WebUploader.create({
            //传递数据
            formData: {'_token': "{{ csrf_token() }}"},

            // 选完文件后，是否自动上传。
            auto: true,

            // swf文件路径
            swf: "{{ asset('common/vendor/webuploader/Uploader.swf') }}",

            // 文件接收服务端。
            server: "{{ url('admin/upload/qiniu') }}",

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/jpg,image/jpeg,image/png'
            }
        });
        // 当有文件添加进来的时候
        uploader.on('fileQueued', function (file) {
            console.log(file);
            $list = $("#fileList");
            var $li = $(
                    '<div id="' + file.id + '" class="file-item thumbnail">' +
                    '<img>' +
                    '</div>'
                ),
                $img = $li.find('img');
            var old_img = $list.find('div');
            if (old_img) {
                old_img.remove();
            }

            // $list为容器jQuery实例
            $list.append($li);

            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader.makeThumb(file, function (error, src) {
                if (error) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }
                $img.attr('src', src);
            }, 150, 150);
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on('uploadSuccess', function (file, data) {
            if (data.status == 1) {
                layer.msg(data.msg, {icon: 1, time: 1000});
                $("input[name=cover_img]").val(data.filepath);
            } else {
                layer.msg(data.msg, {icon: 2, time: 1000});
            }
        });


        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        $("#form-admin-add").validate({
            rules: {
                protype_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 16
                },
            },
            onkeyup: false,
            focusCleanup: true,
            success: "valid",
            submitHandler: function (form) {
                $("form").ajaxSubmit({
                    type: 'post',
                    url: "{{ url('admin/course/add') }}",
                    success: function (data) {
                        if (data.status == 1) {
                            layer.msg(data.msg, {icon: 1, time: 1000});
                            setTimeout(function () {
                                parent.location.reload();
                                var index = parent.layer.getFrameIndex(window.name);
                                parent.layer.close(index);
                            }, 1000);
                        } else {
                            layer.msg(data.msg, {icon: 2, time: 1000});
                        }
                    },
                });
            }
        });
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>