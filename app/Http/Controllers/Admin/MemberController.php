<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    /* @fun: 会员列表
     * @author: fanzhiyi
     * @date: 2017/7/14 15:00
     * @param:
     * @return:
     */
    public function index(Request $request)
    {
        if($request->isMethod('get')){
            return view('admin.member.index');
        }

        if($request->isMethod('post')){
            $pagesize = $request->get('pageSize');
            $pagestart = $request->get('page') - 1;
            $offset = $pagestart * $pagesize;

            //拼接查询条件
            $query = Member::query();//查询对象
            //开始时间
            if ($start = $request->get('updated_start')) {
                $query->where('created_at', '>', $start);
            }
            //终止时间
            if ($end = $request->get('updated_end')) {
                $query->where('created_at', '<', $end);
            }
            if ($brand_name = $request->get('manage_name')) {
                $query->where('username', 'LIKE', '%' . $brand_name . '%');
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

    /* @fun: 会员添加
     * @author: fanzhiyi
     * @date: 2017/7/14 15:00
     * @param:
     * @return:
     */
    public function add(Request $request)
    {
        if($request->isMethod('get')){
            $role = Member::get();
            return view('admin.member.add')->with('role',$role);
        }

        if($request->isMethod('post')){
            //接受要入库的数据

            $input = $request->except(['_token','password2','file']);
            $input['password'] = bcrypt($input['password']);

            if($request->get('password') !== $request->get('password2')){
                return back()->withErrors('两次密码不一致!');
            }
            //验证数据是否合法
            $this->validate($request, [
                'username' => 'required|unique:member,username|min:4|max:20',
                'password' => 'required|min:4|max:20',
            ]);

            //去掉空数据
            $input = delRepeat($input);

            //执行添加新数据
            $inc = Member::create($input)->incrementing;//增量

            //判断结果
            if ($inc) {
                return [
                    'status' => '1',
                    'msg' => '添加成功!',
                ];
            } else {
                return [
                    'status' => '2',
                    'msg' => '添加失败!',
                ];
            }
        }
    }

    /* @fun: 修改会员
     * @author: fanzhiyi
     * @date: 2017/7/15 18:59
     * @param:
     * @return:
     */
    public function edit($id,Request $request)
    {
        if($request->isMethod('get')){
            $data = Member::find($id);
            if(!$data){
                echo "<script type='text/javascript'>
                layer.alert('数据不存在!');
                </script>";
                exit;
            }

            return view('admin.member.edit')->with(['edit' => $data]);
        }

        if($request->isMethod('post')){

            //获取准备更新的数据
            $input = $request->only(['username','password','gender','mobile','email','role_id','status','avatar','type','remark']);

            //去除空数据
            $input = delRepeat($input);

            //密码加密
            if(isset($input['password'])){
                $input['password'] = bcrypt($input['password']);
            }

            //执行更新操
            $res = Member::where('id','=',$id)->update($input);

            //返回执行结果
            if($res){
                return [
                    'status' => 1,
                    'msg' => 'update success!'
                ];
            } else {
                return [
                    'status' => 2,
                    'msg' => 'update failed!'
                ];
            }
        }

    }

    /* @fun: 批量删除品牌
     * @author: fanzhiyi
     * @date: 2017/7/9 21:50
     * @param: $ids 要删除数据的id
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
            $res = Member::whereIn('id', $id)->delete();//返回受影响的行数
        } else {
            $res = Member::where('id', $id)->delete();
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

}
