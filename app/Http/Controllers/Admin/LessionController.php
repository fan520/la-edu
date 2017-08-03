<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Lession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LessionController extends Controller
{
    /* @fun: 课程展示
     * @author: fanzhiyi
     * @date: 2017/7/7 11:26
     * @param:
     * @return:
     */
    public function index(Request $request)
    {
        if ($request->isMethod('get')) {

            return view('admin.lession.index');
        }

        if ($request->isMethod('post')) {
            $pagesize = $request->get('pageSize');
            $pagestart = $request->get('page') - 1;
            $offset = $pagestart * $pagesize;

            //拼接查询条件
            $query = Lession::query();//查询对象
            //开始时间
            if ($start = $request->get('updated_start')) {
                $query->where('updated_at', '>', $start);
            }
            //终止时间
            if ($end = $request->get('updated_end')) {
                $query->where('updated_at', '<', $end);
            }
            if ($Protype_name = $request->get('brand_name')) {
                $query->where('lession_name', 'LIKE', '%' . $Protype_name . '%');
            }
            $data = $query->leftjoin('course','course.id','=','lession.course_id')->select('lession.*','course.course_name')->offset($offset)->limit($pagesize)->get()->toArray();

            return [
                'draw' => $request->get('draw'),
                'recordsFiltered' => $query->count(),//被检索后的数量
                'recordsTotal' => $query->count(),//总记录数
                'data' => $data//返回的数据
            ];
        }
    }

    /* @fun: 添加课程
     * @author: fanzhiyi
     * @date: 2017/7/7 15:04
     * @param:
     * @return:
     */
    public function add(Request $request)
    {
        if ($request->isMethod('get')) {
            //取出专业数据
            $profession =  Profession::get();

            return view('admin/course/add')->with(['profession'=>$profession]);
        }

        if ($request->isMethod('post')) {
            //数据验证
            $this->validate($request, [
                'course_name' => 'required|unique:course,course_name|max:255',
                'profession_id' => 'required',
                'status' => 'required',
            ]);

            //接受入库的数据
            $data = $request->only(['course_name','profession_id','cover_img','sort','status','description']);

            //删除空数据
            $data = delRepeat($data);

            //插入数据
            $res = Course::create($data);

            if ($res) {
                return ['status' => 1,'msg' => 'add success!'];
            } else {
                return ['status' => 2,'msg' => 'add failed!'];
            }
        }
    }

    /* @fun: 批量删除试题
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
        }else{
            //批量删除
            if (is_array($id)) {
                $res = Course::whereIn('id', $id)->delete();//返回受影响的行数
            } else {
                $res = Course::where('id', $id)->delete();
            }
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


    /* @fun: 修改试题的显示页面
     * @author: fanzhiyi
     * @date: 2017/7/10 11:37
     * @param: $id 要修改的试题id
     * @return:
     */
    public function edit($id, Request $request)
    {
        if ($request->isMethod('get')) {
            //取出专业数据
            $profession =  Profession::get();

            //获取要修改的这条数据
            $edit = DB::table('course')->where('id', $id)->first();;

            //返回数据并显示页面
            return view('admin.course.edit')->with(['edit'=>$edit,'profession'=>$profession]);
        }

        if ($request->isMethod('post')) {
            //数据验证
            $this->validate($request, [
                'course_name' => 'required|unique:course,course_name|max:255',
                'profession_id' => 'required',
                'status' => 'required',
            ]);

            //接受入库的数据
            $data = $request->only(['course_name','profession_id','cover_img','sort','status','description']);

            //删除空数据
            $data = delRepeat($data);

            //插入数据
            $res = Course::where('id',$id)->update($data);

            if ($res) {
                return ['status' => 1,'msg' => 'edit success!'];
            } else {
                return ['status' => 2,'msg' => 'edit failed!'];
            }
        }
    }
}
