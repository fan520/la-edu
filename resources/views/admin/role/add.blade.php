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
    <title>添加角色 - 角色管理 - H-ui.admin v2.4</title>
    <meta name="keywords" content="H-ui.admin v3.0,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
    <meta name="description" content="H-ui.admin v3.0，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<article class="page-container">
    <form class="form form-horizontal" id="form-admin-add" method="POST" action="{{ url('admin/manage') }}">
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
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>角色名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="adminName" name="username">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">权限：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <dl class="permission-list">
                    <dd>
                        <dl class="cl permission-list2">
                            @foreach($p_role as $p)
                                <dt>
                                    <label class="">
                                        <input type="checkbox" value="" name="user-Character-0-1"
                                               id="user-Character-0-1">
                                        {{ $p->auth_name }}</label>
                                </dt>
                                <dd>
                                @foreach($c_role as $c)
                                    @if($c->pid === $p->id)

                                            <label class="">
                                                <input type="checkbox" value="" name="user-Character-0-1-0"
                                                       id="user-Character-0-1-0">
                                                {{ $c->auth_name }}</label>

                                    @endif
                                @endforeach
                                </dd>
                            @endforeach
                        </dl>
                    </dd>
                </dl>

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