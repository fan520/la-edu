<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /* @fun: 管理员列表
     * @author: fanzhiyi
     * @date: 2017/7/14 15:00
     * @param:
     * @return:
     */
    public function index(Request $request)
    {
        if($request->isMethod('get')){
            return view('admin.auth.index');
        }

        if($request->isMethod('post')){
            //字段映射排序准备
            $data_map = [
                '1' => 'id',
                '2' => 'auth_name',
                '3' => 'controller',
                '4' => 'action',
                '5' => 'pid',
                '6' => 'is_nav',
            ];

            //接受传递过来的要排序的映射下表
            $map_key = $request->get('order')[0]['column'];
            if(!$map_key){
                $map_key = 1;
            }
            //顺序还是倒序
            $orderByRule = $request->get('order')[0]['dir'];

            $orderFiels = $data_map[$map_key];

            $pagesize = $request->get('pageSize');
            $pagestart = $request->get('page') - 1;
            $offset = $pagestart * $pagesize;

            //拼接查询条件
            $query = Auth::query();//查询对象
            //开始时间
            if ($start = $request->get('updated_start')) {
                $query->where('created_at', '>', $start);
            }
            //终止时间
            if ($end = $request->get('updated_end')) {
                $query->where('created_at', '<', $end);
            }
            if ($brand_name = $request->get('manage_name')) {
                $query->where('auth_name', 'LIKE', '%' . $brand_name . '%');
            }
            $data = $query->orderBy($orderFiels,$orderByRule)->offset($offset)->limit($pagesize)->get()->toArray();
            //取出上级权限
            $all = [];
            foreach ($data as $k => $v) {
                $res = Auth::where('id', '=', $v['pid'])->select('auth_name')->first();
                if ($res['auth_name']) {
                    $v['parent_name'] = $res['auth_name'];
                } else {
                    $v['parent_name'] = "顶级";
                }

                $all[$k] = $v;
            }

            return [
                'draw' => $request->get('draw'),
                'recordsFiltered' => $query->count(),//被检索后的数量
                'recordsTotal' => $query->count(),//总记录数
                'data' => $all//返回的数据
            ];
        }

    }


    /* @fun: 管理员添加
     * @author: fanzhiyi
     * @date: 2017/7/14 15:00
     * @param:
     * @return:
     */
    public function add(Request $request)
    {
        if($request->isMethod('get')){
            //获取顶级权限
            $p_auth = Auth::select('id','auth_name')->where('pid','0')->get();
            return view('admin.auth.add')->with(['p_auth' => $p_auth]);
        }

        if($request->isMethod('post')){
            //接受要入库的数据
            $input = $request->except(['_token']);

            //验证数据是否合法
            $this->validate($request, [
                'auth_name' => 'required|unique:auth,auth_name',
                'controller' => 'required',
                'is_nav' => 'required',
                'pid' => 'required',
            ]);

            //去掉空数据
            $input = delRepeat($input);

            //转成小写
            foreach($input as  $k => $v){
                if($k=='controller' || $k=='action'){
                    $input[$k] = strtolower($input[$k]);
                }
            }

            //执行添加新数据
            $inc = Auth::create($input)->incrementing;//增量

            //判断结果
            if ($inc) {
                echo "<script type='text/javascript'>
                alert('添加成功!');
                var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                parent.location.reload(); // 父页面刷新
                parent.layer.close(index);//关闭当前弹出层
                </script>";
            } else {
                echo "<script type='text/javascript'>alert('添加失败!');window.location.href='admin/auth';</script>";
            }
        }
    }

    /* @fun: 删除权限
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
        if (!$id) {
            $res = false;
        }

        //批量删除
        if (is_array($id)) {
            $res = Auth::whereIn('id', $id)->delete();//返回受影响的行数
        } else {
            $res = Auth::where('id', $id)->delete();
        }

        //返回结果
        if ($res) {
            return [
                'status' => 1,
                'msg' => 'del success!'
            ];
        } else {
            return [
                'status' => 2,
                'msg' => 'del failed!'
            ];
        }
    }



    /* @fun: 修改权限
     * @author: fanzhiyi
     * @date: 2017/7/15 18:59
     * @param:
     * @return:
     */
    public function edit($id,Request $request)
    {
        if($request->isMethod('get')){
            $data = Auth::find($id);
            if(!$data){
                echo "<script type='text/javascript'>
                layer.alert('数据不存在!');
                </script>";
                exit;
            }

            //获取顶级权限
            $p_auth = Auth::select('id','auth_name')->where('pid','0')->get();

            return view('admin.auth.edit')->with('edit',$data)->with('p_auth',$p_auth);
        }

        if($request->isMethod('post')){
            //获取准备更新的数据
            $input = $request->only(['auth_name','controller','action','pid','is_nav']);

            //验证数据是否合法
            $this->validate($request, [
                'auth_name' => 'required',
                'controller' => 'required',
                'is_nav' => 'required',
                'pid' => 'required',
            ]);

            //执行更新操
            $res = Auth::where('id','=',$id)->update($input);

            //返回执行结果
            if($res){
                echo "<script type='text/javascript'>
                alert('修改成功!');
                var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                parent.location.reload(); // 父页面刷新
                parent.layer.close(index);//关闭当前弹出层
                </script>";
            } else {
                return back()->withErrors('修改失败!');
            }
        }
    }

}
