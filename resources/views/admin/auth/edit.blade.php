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
    <title>修改权限 - 权限管理 - H-ui.admin v2.4</title>
    <meta name="keywords" content="H-ui.admin v3.0,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
    <meta name="description" content="H-ui.admin v3.0，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<article class="page-container">
    <form class="form form-horizontal" id="form-admin-add" method="post" action="{{ url('admin/auth') }}/{{ $edit->id }}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="id" value="{{ $edit->id}}">
        <input type="hidden" name="_method" value="put">
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
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text"  placeholder="" id="auth_name" name="auth_name" value="{{ $edit->auth_name }}">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">父级权限：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="pid" size="1">
                <option value="0">--顶级权限--</option>
                @foreach($p_auth as $v)
                    <option value="{{ $v->id }}" @if($edit->pid == $v->id) selected @endif>{{ $v->auth_name }}</option>
                @endforeach
			</select>
			</span></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>控制器：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" autocomplete="off"  name="controller" value="{{ $edit->controller }}">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>方法：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" autocomplete="off"  name="action" value="{{ $edit->action }}">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>菜单：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="radio-box">
                    <input name="is_nav" type="radio" id="sex-1" value="1" @if($edit->is_nav == 1) checked @endif>
                    <label for="sex-1">是</label>
                </div>
                <div class="radio-box">
                    <input type="radio" id="sex-2" name="is_nav" value="2" @if($edit->is_nav == 2) checked @endif>
                    <label for="sex-2">否</label>
                </div>
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
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{ asset('admin/lib/jquery.validation/1.14.0/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/lib/jquery.validation/1.14.0/validate-methods.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/lib/jquery.validation/1.14.0/messages_zh.js') }}"></script>
<script type="text/javascript">
    $(function () {
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        $("#form-admin-add").validate({
            rules: {
                username: {
                    required: true,
                    minlength: 4,
                    maxlength: 16
                },
                password: {
                    required: true,
                },
                password2: {
                    required: true,
                    equalTo: "#password"
                },
                sex: {
                    required: true,
                },
                phone: {
                    required: true,
                    isPhone: true,
                },
                adminRole: {
                    required: true,
                },
            },
            onkeyup: false,
            focusCleanup: true,
            success: "valid",
            {{--submitHandler:function(form){--}}
            {{--$(form).ajaxSubmit({--}}
            {{--type: 'post',--}}
            {{--url: "{{ url('admin/manage') }}" ,--}}
            {{--success: function(data){--}}
            {{--console.log(data);return;--}}
            {{--layer.msg('添加成功!',{icon:1,time:1000});--}}
            {{--},--}}
            {{--error: function(XmlHttpRequest, textStatus, errorThrown){--}}
            {{--layer.msg('error!',{icon:1,time:1000});--}}
            {{--}--}}
            {{--});--}}
            {{--var index = parent.layer.getFrameIndex(window.name);--}}
            {{--parent.$('.btn-refresh').click();--}}
            {{--parent.layer.close(index);--}}
            {{--}--}}
        });
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>