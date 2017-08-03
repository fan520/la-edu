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
    <title>添加试题 - 试题管理 </title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link href="http://cdn.bootcss.com/bootstrap/3.3.1/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
    <link href="{{ asset('common/vendor/webuploader/webuploader.css') }}" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="http://cdn.bootcss.com/jquery/1.9.1/jquery.js"></script>
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
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>所属试卷：</label>
            <div class="formControls col-xs-8 col-sm-8"> <span class="select-box" style="width:150px;">
			<select class="select" name="paper_id" size="1">
               <option value="0">请选择</option>
				@foreach($paper as $v)
                    <option value="{{ $v->id }}"> {{ $v->paper_name }}</option>
                @endforeach
			</select>
			</span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>试题内容：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <textarea class="textarea" style="" id="question" name="question"></textarea>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>选项内容：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <textarea class="textarea" style="" id="options" name="options"></textarea>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">本题答案：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <input type="text" class="input-text" value="" placeholder="" id="answer" name="answer">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">本题总分：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <input type="text" class="input-text" value="" placeholder="" id="score" name="score">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">备注：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <input type="text" class="input-text" value="" placeholder="" id="remark" name="remark">
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
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });


        /*uploader-start*/
        var $list=$("#thelist");   //这几个初始化全局的百度文档上没说明，好蛋疼。
        var $btn =$("#ctlBtn");   //开始上传
        var thumbnailWidth = 150;   //缩略图高度和宽度 （单位是像素），当宽高度是0~1的时候，是按照百分比计算，具体可以看api文档
        var thumbnailHeight = 150;

        var uploader = WebUploader.create({
            formData:{'_token':"{{ csrf_token() }}"},
            // 选完文件后，是否自动上传。
            auto: false,

            // swf文件路径
            swf: "{{ asset('common/vendor/webuploader/Uploader.swf') }}",

            // 文件接收服务端。
            server: "{{ url('admin/brand/logo') }}",

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: {id:$('#filePicker'),multiple:false},//只能选中一张图片

            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/jpg,image/jpeg,image/png'   //默认是所有'image/*',但是这样会反应很慢,所以还是改成自定义的格式速度会很快
            },
            method:'POST',
            multiple:false
        });

        // 当有文件添加进来的时候
        uploader.on( 'fileQueued', function( file ) {  // webuploader事件.当选择文件后，文件被加

            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader.makeThumb( file, function( error, src ) {   //webuploader方法
//            if ( error ) {
//                layer.alert("图片错误,请重新添加!");
//                return;
//            }

                //上面的html代码中已经有一个img,这里最多允许添加一张图片,所以有新图片添加进来的时候,会替换掉原来的图片,而不是新加入一个
                $('#logo_thumb').prop( 'src', src );
            }, thumbnailWidth, thumbnailHeight );
        });



        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function( file ,res) {

            if(res.status==1){//上传成功!
                $('#brand_logo').val(res.url);

                //提示成功信息
                layer.msg(res.msg, {icon: 6});

                //关闭添加页面
//			setTimeout(function(){
//                var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
//                parent.layer.close(index);//关闭当前弹出层
//			},2000);
            } else{//上传失败!
                //提示上传失败信息
                layer.msg(res.msg, {icon: 5});
            }
        });

        //执行上传动作
        $btn.on( 'click', function() {
            uploader.upload();
        });
        /*uploader-end*/

//	var ue = UE.getEditor('editor');

    });

    $(function () {
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
                    url: "{{ url('admin/question/add') }}",
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