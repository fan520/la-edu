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
    @include('admin.common.header')
    <title>导出试题 - 试题管理 </title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="http://cdn.bootcss.com/bootstrap/3.3.1/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="{{asset('admin/lib/jquery/1.9.1/jquery.min.js')}}"></script>
    <script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

</head>
<body>

<article class="page-container">
    <form class="form form-horizontal" id="form-admin-add" method="post" method="{{ url('admin/question/export') }}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
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
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <input type="submit" value="导出" class="btn btn-secondary radius">
                <button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
    </form>
</article>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="{{asset('admin/lib/layer/2.4/layer.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/static/h-ui/js/H-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/static/h-ui.admin/js/H-ui.admin.js')}}"></script>
<!--/_footer /作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{asset('admin/lib/My97DatePicker/4.8/WdatePicker.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/lib/ueditor/1.4.3/ueditor.config.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/lib/ueditor/1.4.3/ueditor.all.min.js')}}"> </script>
<script type="text/javascript" src="{{asset('admin/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js')}}"></script>
<script type="text/javascript">
    //取消按钮
    function removeIframe() {
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }
    $(function () {
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
        $("#form-admin-add").validate({
            rules: {
                paper_id: {
                    required: true,
                },
            },
            onkeyup: false,
            focusCleanup: true,
            success: "valid",
            {{--submitHandler: function (form) {--}}
            {{--$("form").ajaxSubmit({--}}
            {{--type: 'post',--}}
            {{--url: "{{ url('admin/question/import') }}",--}}
            {{--success: function (data) {--}}
            {{--data = JSON.parse(data);//把json字符串转成json对象--}}
            {{--if (data.status == 1) {--}}
            {{--layer.msg(data.msg, {icon: 1, time: 1000});--}}
            {{--setTimeout(function () {--}}
            {{--parent.location.reload();--}}
            {{--var index = parent.layer.getFrameIndex(window.name);--}}
            {{--parent.layer.close(index);--}}
            {{--}, 1000);--}}
            {{--} else {--}}
            {{--layer.msg('失败', {icon: 2, time: 1000});--}}
            {{--}--}}
            {{--},--}}
            {{--});--}}
            {{--}--}}
        });
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>