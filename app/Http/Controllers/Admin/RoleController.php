<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Auth;
use App\Models\Admin\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class RoleController extends Controller
{
    /* @fun: 角色列表
     * @author: fanzhiyi
     * @date: 2017/7/14 15:00
     * @param:
     * @return:
     */
    public function index(Request $request)
    {
        if($request->isMethod('get')){

            return view('admin.role.index');

        }elseif($request->isMethod('post')){
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
    public function add(Request $request)
    {
        if ($request->isMethod('get')) {
            //顶级权限
            $p_role = Auth::where('pid', '0')->get();
            //二级权限
            $c_role = Auth::where('pid', '>', '0')->get();

            return view('admin.role.add')->with(['p_role' => $p_role, 'c_role' => $c_role]);

        } elseif ($request->isMethod('post')) {
            //接受要入库的数据
            $input['role_name'] = $request->get('role_name');
            $input['auth_ids'] = implode(',',$request->get('auth_ids'));

            //验证数据是否合法
            $this->validate($request, [
                'role_name' => 'required|unique:role,role_name',
            ]);

            //去掉空数据
            $input = delRepeat($input);

            //执行添加新数据
            $inc = Role::create($input)->incrementing;//增量

            //判断结果
            if ($inc) {
                echo "<script type='text/javascript'>
                alert('添加成功!');
                var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                parent.location.reload(); // 父页面刷新
                parent.layer.close(index);//关闭当前弹出层
                </script>";
            } else {
                echo "<script type='text/javascript'>alert('添加失败!');window.location.href='admin/role/index';</script>";
            }
        }
    }

    /* @fun: 删除角色
     * @author: fanzhiyi
     * @date: 2017/7/17 15:44
     * @param:
     * @return:
     */
    public function del(Request $request)
    {
        $id = $request->get('id');

        //结果保存
        $res = '';

        //非空判断
        if(!$id){
            $res = false;
        }

        //批量删除
        if(is_array($id)){
            $res = Role::whereIn('id',$id)->delete();//返回受影响的行数
        }else{
            $res = Role::where('id',$id)->delete();
        }

        //返回结果
        if($res){
            return [
                'status' => 1,
                'msg' => 'del success!'
            ];
        }else{
            return [
                'status' => 2,
                'msg' => 'del failed!'
            ];
        }
    }

    /* @fun: 编辑
     * @author: fanzhiyi
     * @date: 2017/7/17 16:16
     * @param:
     * @return:
     */
    public function edit($id,Request $request)
    {
        //编辑页面显示
        if($request->isMethod('get')){
            //顶级权限
            $p_role = Auth::where('pid', '0')->get();
            //二级权限
            $c_role = Auth::where('pid', '>', '0')->get();

            //当前角色拥有的权限
            $role = Role::where('id',$id)->select('auth_ids')->first()->toarray();
            P($role);

            return view('admin.role.edit')->with([
                'p_role' => $p_role,
                'c_role' => $c_role,
                'role' => $role['0'],
                'id' => $id
            ]);
        }

        //修改数据处理
        if($request->isMethod('post')){

        }

    }
}
