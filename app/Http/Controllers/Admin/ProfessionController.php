<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Member;
use App\Models\Admin\Profession;
use App\Models\Admin\Protype;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProfessionController extends Controller
{
    /* @fun: 专业分类列表展示
     * @author: fanzhiyi
     * @date: 2017/7/7 11:26
     * @param:
     * @return:
     */
    public function index(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.profession.index');
        }

        if ($request->isMethod('post')) {
            $pagesize = $request->get('pageSize');
            $pagestart = $request->get('page') - 1;
            $offset = $pagestart * $pagesize;

            //拼接查询条件
            $query = Profession::query();//查询对象
            //开始时间
            if ($start = $request->get('updated_start')) {
                $query->where('updated_at', '>', $start);
            }
            //终止时间
            if ($end = $request->get('updated_end')) {
                $query->where('updated_at', '<', $end);
            }
            if ($Protype_name = $request->get('brand_name')) {
                $query->where('pro_name', 'LIKE', '%' . $Protype_name . '%');
            }
            $data = $query->join('protype', 'protype.id', '=', 'profession.protype_id')->select('profession.*', 'protype.protype_name')->offset($offset)->limit($pagesize)->get()->toArray();

//            $datas = [];
//            //添加父级分类的名称
//            foreach($data as $k => $v){
//                $parent_name  = DB::table('profession')->where('id',$v['pid'])->first();
//                if($parent_name){
//                    $v['parent_name'] = $parent_name->protype_name;
//                }
//                $datas[$k] = $v;
//            }

            return [
                'draw' => $request->get('draw'),
                'recordsFiltered' => $query->count(),//被检索后的数量
                'recordsTotal' => $query->count(),//总记录数
                'data' => $data//返回的数据
            ];
        }
    }

    /* @fun: 添加专业分类
     * @author: fanzhiyi
     * @date: 2017/7/7 15:04
     * @param:
     * @return:
     */
    public function add(Request $request)
    {
        if ($request->isMethod('get')) {
            //取出分类数据
            $protype = Protype::get()->toarray();

            //取出老师数据
            $teachers = Member::where('type', 2)->select('id', 'username')->get();

            //无限极分类
            $protype = getTree($protype);
            return view('admin/profession/add')->with(['protype' => $protype, 'teachers' => $teachers]);
        }

        if ($request->isMethod('post')) {
            //数据验证
            $this->validate($request, [
                'pro_name' => 'required|unique:protype,protype_name|max:255',

            ], [
                'pro_name.required' => '专业名称不能为空!'
            ]);

            //接受入库的数据
            $data = $request->except('_token', 'file');

            //删除空数据
            $data = delRepeat($data);

            //授课老师处理成字符串
            $data['teachers_ids'] = implode(',', $data['teachers_ids']);

            //插入数据
            $res = Profession::create($data);

            if ($res) {
                echo "<script type='text/javascript'>parent.window.location.reload();
                     var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                     parent.layer.close(index);</script>";
            } else {
                return back();
            }

        }

    }

    /* @fun: 批量删除专业分类
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
            $res = Profession::whereIn('id', $id)->delete();//返回受影响的行数
        } else {
            $res = Profession::where('id', $id)->delete();
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


    /* @fun: 修改专业分类的显示页面
     * @author: fanzhiyi
     * @date: 2017/7/10 11:37
     * @param: $id 要修改的专业分类id
     * @return:
     */
    public function edit($id, Request $request)
    {
        if ($request->isMethod('get')) {
            //获取要修改的这条数据
            $edit = Protype::find($id);

            //取出分类数据
            $data = Protype::get()->toarray();

            //无限极分类
            $data = getTree($data);

            //返回数据并显示页面
            return view('admin.Protype.edit')->with(['edit' => $edit, 'data' => $data]);
        }

        if ($request->isMethod('post')) {
            //获取准备更新的数据
            $input = $request->only(['protype_name', 'pid', 'sort', 'status', 'remark']);

            //删除空数据
            $data = delRepeat($input);

            //执行更新操
            $res = Protype::where('id', '=', $id)->update($input);

            //返回执行结果
            if ($res) {
                return [
                    'status' => 1,
                    'msg' => 'edit success!'
                ];
            } else {
                return [
                    'status' => 2,
                    'msg' => 'edit failed!'
                ];
            }
        }
    }
}
