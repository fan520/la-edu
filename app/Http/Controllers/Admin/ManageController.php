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

    /* @fun: 管理员列表
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
        $query = Admin::query();//查询对象
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

    /* @fun: 修改管理员
     * @author: fanzhiyi
     * @date: 2017/7/15 18:59
     * @param:
     * @return:
     */
    public function edit($id)
    {
        $data = Admin::find($id);
        if(!$data){
            echo "<script type='text/javascript'>
                layer.alert('数据不存在!');
                </script>";
                exit;
        }
        return view('admin.manage.edit')->with('edit',$data);
    }

    /* @fun: 修改管理员处理
     * @author: fanzhiyi
     * @date: 2017/7/15 18:59
     * @param:
     * @return:
     */
    public function update(Request $request)
    {
        //获取准备更新的数据
        $id = $request->get('id');
        $input = $request->only(['username','password','gender','mobile','email','role_id','status']);
        $input['password'] = bcrypt($input['password']);
        //执行更新操
        $res = Admin::where('id','=',$id)->update($input);

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

    /* @fun: 批量删除品牌
     * @author: fanzhiyi
     * @date: 2017/7/9 21:50
     * @param: $ids 要删除数据的id
     * @return:
     */
    public function batchDel(Request $request)
    {
        //获取要删除数据的id
        $ids = $request->get('ids');
        if(!$ids){
            return [
                'status' => false,
            ];
        }

        Admin::whereIn('id',$ids)->get()->each(function($i){
            $i->delete();
        });

        return [
            'status' => true,
        ];
    }

    /* @fun: 删除一条数据
     * @author: fanzhiyi
     * @date: 2017/7/10 10:57
     * @param: $id 要删除的数据的id
     * @return:json
     */
    public function destroy(Request $request)
    {
        $id = $request->get('id');
        //使用Brand模型执行删除可以实现假删除,如果使用DB::table()->where()->delete(),会真删除
        $res = Admin::where('id','=',$id)->delete();
        if($res){
            return [
                'status' => true
            ];
        }else{
            return [
                'status' => false
            ];
        }
    }

}
