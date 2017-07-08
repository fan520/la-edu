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
    <title>新增文章 - 资讯管理 - H-ui.admin v3.0</title>
    <meta name="keywords" content="H-ui.admin v3.0,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
    <meta name="description" content="H-ui.admin v3.0，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">

    <link href="http://cdn.bootcss.com/bootstrap/3.3.1/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
    <link href="{{ asset('common/vendor/webuploader/webuploader.css') }}" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="http://cdn.bootcss.com/jquery/1.9.1/jquery.js"></script>
    <script type="text/javascript" src="{{ asset('common/vendor/webuploader/webuploader.min.js') }}"></script>
    <script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

</head>
<body>

<article class="page-container">
    <form class="form form-horizontal" id="form-article-add" action="{{url('admin/brand')}}" method="post">
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
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>品牌名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="articletitle" name="brand_name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">site：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="http://www." placeholder="" id="articletitle2" name="brand_site">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">logo：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div id="thelist" class="uploader-list">
                    <div id="' + file.id + '" class="file-item thumbnail">
                        <img style="display:inline;margin-bottom: 5px;border-radius:5px;" id="logo_thumb" />
                        <input type="hidden" name="brand_logo" id="brand_logo">
                    </div>
                </div>
                <div>
                    <div id="filePicker" style="display:inline;">选择图片</div>
                    <div id="ctlBtn" class="webuploader-pick" style="background-color: #429842;">开始上传</div>
                </div>
            </div>
        </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">描述：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="description" cols="" rows="" class="textarea"   datatype="*10-100" dragonfly="true"  ></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
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
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>