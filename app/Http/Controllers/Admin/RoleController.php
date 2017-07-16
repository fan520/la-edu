<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Auth;
use App\Models\Admin\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /* @fun: 角色列表
     * @author: fanzhiyi
     * @date: 2017/7/14 15:00
     * @param:
     * @return:
     */
    public function index()
    {
        return view('admin.role.index');
    }

    /* @fun: 角色列表
     * @author: fanzhiyi
     * @date: 2017/7/14 15:00
     * @param:
     * @return:
     */
    public function getList(Request $request)
    {

        $pagesize = $request->get('pageSize');
        $pagestart = $request->get('page') - 1;
        $offset = $pagestart * $pagesize;

        //拼接查询条件
        $query = Role::query();//查询对象
        //开始时间
        if ($start = $request->get('updated_start')) {
            $query->where('created_at', '>', $start);
        }
        //终止时间
        if ($end = $request->get('updated_end')) {
            $query->where('created_at', '<', $end);
        }
        if ($brand_name = $request->get('manage_name')) {
            $query->where('role_name', 'LIKE', '%' . $brand_name . '%');
        }
        $data = $query->offset($offset)->limit($pagesize)->get()->toArray();

        return [
            'draw' => $request->get('draw'),
            'recordsFiltered' => $query->count(),//被检索后的数量
            'recordsTotal' => $query->count(),//总记录数
            'data' => $data//返回的数据
        ];
    }

    /* @fun: 角色分配权限
     * @author: fanzhiyi
     * @date: 2017/7/16 16:26
     * @param:
     * @return:
     */
    public function allocate_auth($id)
    {
        $role = Role::find($id);
        return view('admin.role.role_auth_add');
    }

    /* @fun: 角色添加
     * @author: fanzhiyi
     * @date: 2017/7/14 15:00
     * @param:
     * @return:
     */
    public function create()
    {
        //顶级权限
        $p_role = Auth::where('pid','0')->get();

        //二级权限
        $c_role = Auth::where('pid','>','0')->get();

        return view('admin.role.add')->with(['p_role'=>$p_role,'c_role'=>$c_role]);
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
