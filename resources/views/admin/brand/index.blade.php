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
    <title>品牌管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 品牌管理 <span
            class="c-gray en">&gt;</span> 品牌列表 <a class="btn btn-success radius r"
                                                  style="line-height:1.6em;margin-top:3px"
                                                  href="javascript:location.replace(location.href);" title="刷新"><i
                class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c"> 日期范围：
        <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin"
               class="input-text Wdate" style="width:120px;">
        -
        <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax"
               class="input-text Wdate" style="width:120px;">
        <input type="text" class="input-text" style="width:250px" placeholder="输入品牌名称..." id="" name="">
        <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜品牌
        </button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20"><span class="l"><a href="javascript:;" onclick="datadel()"
                                                               class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a
                    href="javascript:;" onclick="member_add()" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加品牌</a></span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="4%"><input type="checkbox" name="" value=""></th>
                <th width="5%">ID</th>
                <th width="10%">品牌</th>
                <th width="15%">site</th>
                <th width="10%">logo</th>
                <th width="14%">添加时间</th>
                <th width="14%">修改时间</th>
                <th width="14%">描述</th>
                <th width="14%">操作</th>
            </tr>
            </thead>
            <tbody class="text-c"></tbody>
        </table>
    </div>
</div>

@include('admin.common.footer')

<script type="text/javascript">
    $(function () {
        $('.table-sort').dataTable({
            "aaSorting": [[1, "desc"]],//默认第几个排序
            "bStateSave": true,//状态保存
            "lengthMenu": [ 2, 5, 10, 20, 50 ],//表格左上角可选每页显示条数
            "searching": false,//关闭本地搜索
            "serverSide": true,//开启服务器模式
            'createdRow': function (row, data) {//当每行创建的时候执行的回调函数
                var $row = $(row);//当前行对象
                //第一列加入复选框
                $row.find('td:eq(0)').html("<input type='checkbox' name='id[]' value='" + data.id + "'/>");
                $row.find('td:eq(4)').html("<img  style='width:80px;border-radius: 5px;' src='" + data.brand_logo + "'/>");
                //最后一列加入内容
                $row.find('td:last').html("<a title='编辑' href='javascript:void(0);' onclick=member_edit('编辑','member-add.html','4','','510') class='ml-5' style='text-decoration:none'><i class='Hui-iconfont'>&#xe6df;</i></a> <a title='删除' href='javascript:void(0);' onclick=member_del(this,'1') class='ml-5' style='text-decoration:none'><i class='Hui-iconfont'>&#xe6e2;</i></a>");

            },
            'ajax': {
                'url': "{{ url('admin/brand/getList') }}",
                'type': "post",
                'data': function (data) {
                    //每页显示的数据量
                    data.pageSize = data.length;
                    //当前是第一页
                    data.page = data.start >= data.length ? Math.ceil(data.start / data.length) + 1 : 1;
                    //添加csrf值
                    data._token = "{{ csrf_token() }}";
                },
            },
            'columns': [
                {'data': 'a', 'defaultContent': ""},
                {'data': 'id'},
                {'data': 'brand_name'},
                {'data': 'brand_site'},
                {'data': 'brand_logo'},
                {'data': 'created_at'},
                {'data': 'updated_at'},
                {'data': 'description'},
                {'data': 'b', 'defaultContent': 'id'},
            ],
            //"stateSave": true,//储存分页位置，每页显示的长度，过滤后的结果和排序
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable": false, "aTargets": [0, 8]}// 制定列不参与排序
            ]
        });

    });
    /*用户-添加*/
    function member_add(title, url, w, h) {
        var title = "添加品牌";//弹窗标题
        var url = "{{ url('admin/brand/create') }}";//弹窗的地址
        var h = "510";//弹窗高度
        layer_show(title, url, w, h);
    }
    /*用户-查看*/
    function member_show(title, url, id, w, h) {
        layer_show(title, url, w, h);
    }
    /*用户-停用*/
    function member_stop(obj, id) {
        layer.confirm('确认要停用吗？', function (index) {
            $.ajax({
                type: 'POST',
                url: '',
                dataType: 'json',
                success: function (data) {
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_start(this,id)" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe6e1;</i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已停用</span>');
                    $(obj).remove();
                    layer.msg('已停用!', {icon: 5, time: 1000});
                },
                error: function (data) {
                    console.log(data.msg);
                },
            });
        });
    }

    /*用户-启用*/
    function member_start(obj, id) {
        layer.confirm('确认要启用吗？', function (index) {
            $.ajax({
                type: 'POST',
                url: '',
                dataType: 'json',
                success: function (data) {
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_stop(this,id)" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
                    $(obj).remove();
                    layer.msg('已启用!', {icon: 6, time: 1000});
                },
                error: function (data) {
                    console.log(data.msg);
                },
            });
        });
    }
    /*用户-编辑*/
    function member_edit(title, url, id, w, h) {
        layer_show(title, url, w, h);
    }
    /*密码-修改*/
    function change_password(title, url, id, w, h) {
        layer_show(title, url, w, h);
    }
    /*用户-删除*/
    function member_del(obj, id) {
        layer.confirm('确认要删除吗？', function (index) {
            $.ajax({
                type: 'POST',
                url: '',
                dataType: 'json',
                success: function (data) {
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!', {icon: 1, time: 1000});
                },
                error: function (data) {
                    console.log(data.msg);
                },
            });
        });
    }
</script>
</body>
</html>