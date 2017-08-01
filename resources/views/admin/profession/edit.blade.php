<!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <!--/meta 作为公共模版分离出去-->
    @include('admin.common.header')
    <title>专业添加 - 专业管理</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
</head>
<body>
<article class="page-container">
    <form class="form form-horizontal" id="form-admin-add" method="post" action="{{ url('admin/profession/add') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row cl">
            @if (count($errors) > 0)
                <div>
                    @foreach ($errors->all() as $error)
                        <div style="margin-left:200px;width:300px;background-color:#FFFF00;border: solid 1px #9da0a4;border-radius: 3px;">
                            <font color="red" style="margin-left:50px;">{{ $error }}</font>
                            <?php break;?>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>专业名称：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <input type="text" class="input-text" value="" placeholder="" id="pro_name"
                       name="pro_name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>所属分类：</label>
            <div class="formControls col-xs-8 col-sm-8"> <span class="select-box" style="width:150px;">
			<select class="select" name="protype_id" size="1">
                @foreach($protype as $v)
                    <option value="{{ $v['id'] }}"> {{ str_repeat("&nbsp;",$v['level']*4) }}{{ $v['protype_name'] }}</option>
                @endforeach
			</select>
			</span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">授课老师：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <dl class="permission-list">
                    <dd style="margin-left: 0px;">
                        @foreach($teachers as $v)
                            <label class="" style="margin-right:10px;display:inline-block;">
                                <input type="checkbox" value="{{ $v->id }}"
                                       name="teachers_ids[]">{{ $v->username }}
                            </label>
                        @endforeach
                    </dd>
                </dl>
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
            <label class="form-label col-xs-4 col-sm-3">幻灯片：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <div id="ppt_upload"></div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>浏览量：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <input type="text" class="input-text" autocomplete="off" value="" placeholder="" id="view_count"
                       name="view_count">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>排序：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <input type="text" class="input-text" autocomplete="off" value="50" placeholder="" id="sort"
                       name="sort">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>课时：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <input type="text" class="input-text" autocomplete="off" value="" placeholder="" id="duration"
                       name="duration">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>价格：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <input type="text" class="input-text" autocomplete="off" value="" placeholder="" id="price"
                       name="price">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">描述：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <input type="text" class="input-text" placeholder="" name="description" id="description"
                       value="">
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>

@include('admin.common.footer')
<script type="text/javascript" src="{{ asset('admin/lib/jquery.validation/1.14.0/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/lib/jquery.validation/1.14.0/validate-methods.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/lib/jquery.validation/1.14.0/messages_zh.js') }}"></script>
{{--webupload--}}
<link rel="stylesheet" type="text/css" href="{{ asset('common/vendor/webuploader/webuploader.css') }}">
<script type="text/javascript" src="{{ asset('common/vendor/webuploader/webuploader.js') }}"></script>

{{--zyupload--}}
<!-- 引用控制层插件样式 -->
<link rel="stylesheet" href="{{ asset('common/vendor/zyupload/control/css/zyUpload.css') }}" type="text/css">
<!-- 引用核心层插件 -->
<script type="text/javascript" src="{{ asset('common/vendor/zyupload/core/zyFile.js') }}"></script>
<!-- 引用控制层插件 -->
<script type="text/javascript" src="{{ asset('common/vendor/zyupload/control/js/zyUpload.js') }}"></script>
<!-- 引用初始化JS -->
{{--<script type="text/javascript" src="{{ asset('common/vendor/zyupload/demo.js') }}"></script>--}}

<script type="text/javascript">


    $(function () {
        //zyupload
        //实例化上传的选择框
        $('#ppt_upload').zyUpload({
            width: "550px", // 宽度
            height: '100%',
            url: "{{ url('admin/upload/qiniu') }}",//配置上传地址
            // 文件上传成功的回调方法，参数file是文件上传的信息，参数responseInfo是服务器的返回值
            // 服务器返回值的形式其是【原始信息：json字符串】
            onSuccess: function (file, responseInfo) {
                //转json字符串为js对象
                var rst = eval('(' + responseInfo + ')');
                //判断是否成功
                if (rst.status === 1) {
                    layer.msg('文件上传成功！', {icon: '1', time: 1500});
                    //追加上传之后的文件路径到容器中
                    $('#duowenjian').append("<input type='hidden' name='ppt_imgs[]' value='" + rst.filepath + "'/>");
                    //before  after   insertBefore  insertAfter  append  appendTo  preprend prependTo
                }
            },
        });

        //监听zyFile.formdata.created事件
        $(document).on('zyFile.formdata.created', function (event, formdata, zyfile) {
            //console.log(formdata);
            formdata.append('_token', "{{csrf_token()}}");//追加token
            //更改上传文件的name值
            zyfile.uploadFileName = 'file';//与后台方法的一致
        });


        $(".permission-list dt input:checkbox").click(function () {
            $(this).closest("dl").find("dd input:checkbox").prop("checked", $(this).prop("checked"));
        });
        $(".permission-list2 dd input:checkbox").click(function () {
            var l = $(this).parent().parent().find("input:checked").length;
            var l2 = $(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
            if ($(this).prop("checked")) {
                $(this).closest("dl").find("dt input:checkbox").prop("checked", true);
                $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked", true);
            }
            else {
                if (l == 0) {
                    $(this).closest("dl").find("dt input:checkbox").prop("checked", false);
                }
                if (l2 == 0) {
                    $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked", false);
                }
            }
        });

        $("#form-admin-add").validate({
            rules: {
                protype_name: {
                    required: true,
                },
            },
            onkeyup: false,
            focusCleanup: true,
            success: "valid",
            {{--submitHandler: function (form) {--}}
            {{--$(form).ajaxSubmit({--}}
            {{--type: 'post',--}}
            {{--url: "{{ url('admin/profession/add') }}",--}}
            {{--success: function (data) {--}}
            {{--if (data.status == 1) {--}}
            {{--layer.msg(data.msg, {icon: 1, time: 1000});--}}
            {{--setTimeout(function () {--}}
            {{--parent.window.location.reload();--}}
            {{--var index = parent.layer.getFrameIndex(window.name);--}}
            {{--parent.layer.close(index);--}}
            {{--}, 1000);--}}
            {{--} else {--}}
            {{--for (var i = 0; i < data.length; i++) {--}}
            {{--console.log(i+":"+data[i]);--}}
            {{--};--}}

            {{--layer.msg(data.msg, {icon: 2, time: 1000});--}}
            {{--}--}}
            {{--},--}}
            {{--error: function (XmlHttpRequest, textStatus, errorThrown) {--}}
            {{--layer.msg('error!', {icon: 2, time: 1000});--}}
            {{--}--}}
            {{--});--}}
            {{--}--}}
        });

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
    });


</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>