<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ManageController extends Controller
{
    /* @fun: 管理员列表
     * @author: fanzhiyi
     * @date: 2017/7/14 15:00
     * @param:
     * @return:
     */
    public function index()
    {
        return view('admin.manage.index');
    }

    /* @fun: 管理员添加
     * @author: fanzhiyi
     * @date: 2017/7/14 15:00
     * @param:
     * @return:
     */
    public function create()
    {
        return view('admin.manage.add');
    }

    /* @fun: 管理员添加处理
     * @author: fanzhiyi
     * @date: 2017/7/14 15:00
     * @param:
     * @return:
     */
    public function store(Request $request)
    {
        //接受要入库的数据
        $input = $request->except(['_token','password2']);
        $input['password'] = bcrypt($input['password']);

        //验证数据是否合法
        $this->validate($request, [
            'username' => 'required|unique:admin,username|min:4|max:20',
            'password' => 'required|min:4|max:20',
            'gender' => 'required',
            'role_id' => 'required',
        ]);

        //去掉空数据
        $input = delRepeat($input);

        //执行添加新数据
        $inc = Admin::create($input)->incrementing;//增量

        //判断结果
        if ($inc) {
            echo "<script type='text/javascript'>
                alert('添加成功!');
                var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                parent.location.reload(); // 父页面刷新
                parent.layer.close(index);//关闭当前弹出层
                </script>";
        } else {
            echo "<script type='text/javascript'>alert('添加失败!');window.location.href='admin/manage';</script>";
        }

    }
}
