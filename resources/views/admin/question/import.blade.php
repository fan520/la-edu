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
    <title>导入试题 - 试题管理 </title>
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
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>试卷名称：</label>
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
            <label class="form-label col-xs-4 col-sm-3">总分：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <div id="uploader" class="wu-example">
                    <!--用来存放文件信息-->
                    <div id="thelist" class="uploader-list"></div>
                    <div class="btns">
                        <div id="picker">选择文件</div>
                        <button id="ctlBtn" class="btn btn-default">开始上传</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <input type="submit" value="导入" class="btn btn-secondary radius">
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

            // swf文件路径
            swf: "{{ asset('common/vendor/webuploader/Uploader.swf') }}",

            // 文件接收服务端。
            server: "{{ url('admin/upload/localpublic') }}",

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: {id:$('#picker'),multiple:false},//只能选中一张图片
        });
        uploader.on( 'fileQueued', function( file ) {
            $list.append( '<div id="' + file.id + '" class="item">' +
                '<h4 class="info">' + file.name + '</h4>' +
                '<p class="state">等待上传...</p>' +
                '</div>' );
        });
        uploader.on( 'uploadSuccess', function( file ,data ) {
            if(data.status == '1'){
                $list.find("div[id="+file.id+"]").find('p').text(data.msg);
                layer.msg(data.msg,{icon:1,time:1000});
                //追加上传文件的路径
                $list.append("<input type='hidden' name='filepath' value='"+data.filepath+"'/>");
            } else{
                layer.msg(data.msg,{icon:2,time:1000});
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
                    url: "{{ url('admin/question/import') }}",
                    success: function (data) {
                        data = JSON.parse(data);//把json字符串转成json对象
                        if (data.status == 1) {
                            layer.msg(data.msg, {icon: 1, time: 1000});
                            setTimeout(function () {
                                parent.location.reload();
                                var index = parent.layer.getFrameIndex(window.name);
                                parent.layer.close(index);
                            }, 1000);
                        } else {
                            layer.msg('失败', {icon: 2, time: 1000});
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