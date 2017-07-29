<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Protype;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProtypeController extends Controller
{
    /* @fun: 专业分类列表展示
     * @author: fanzhiyi
     * @date: 2017/7/7 11:26
     * @param:
     * @return:
     */
    public function index(Request $request)
    {
        if($request->isMethod('get')){
            return view('admin.Protype.index');
        }

        if($request->isMethod('post')){
            $pagesize = $request->get('pageSize');
            $pagestart = $request->get('page') - 1;
            $offset = $pagestart * $pagesize;

            //拼接查询条件
            $query = Protype::query();//查询对象
            //开始时间
            if ($start = $request->get('updated_start')) {
                $query->where('updated_at', '>', $start);
            }
            //终止时间
            if ($end = $request->get('updated_end')) {
                $query->where('updated_at', '<', $end);
            }
            if ($Protype_name = $request->get('brand_name')) {
                $query->where('protype_name', 'LIKE', '%' . $Protype_name . '%');
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

    /* @fun: 添加专业分类
     * @author: fanzhiyi
     * @date: 2017/7/7 15:04
     * @param:
     * @return:
     */
    public function add(Request $request)
    {
        if($request->isMethod('get')){
            return view('admin/Protype/add');
        }

        if($request->isMethod('post')){
            //数据验证
            $this->validate($request, [
                'protype_name' => 'required|unique:protype,protype_name|max:255',
                'status' => 'required',
            ]);

            //接受入库的数据
            $data = $request->except('_token');

            //删除空数据
            $data = delRepeat($data);

            //插入数据
            $res = Protype::create($data);

            if ($res) {
                return [
                    'status' => 1,
                    'msg' => 'add success!'
                ];
            } else {
                return [
                    'status' => 2,
                    'msg' => 'add failed!'
                ];
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
            $res = Protype::whereIn('id', $id)->delete();//返回受影响的行数
        } else {
            $res = Protype::where('id', $id)->delete();
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

    /*
      * @fun 上传logo
      * @author fanzhiyi
      * @date 2017/6/22 21:00
      * @param
      * @return
     */
    public function logo(Request $request)
    {

        //接受上传图片信息
        $file = $request->file('file');

        //验证合法性
        if ($file->isValid()) {
//            $originalName = $file->getClientOriginalName(); // 文件原名
//            $type = $file->getClientMimeType();     // image/jpeg
            $ext = $file->getClientOriginalExtension();     // 扩展名
            $realPath = $file->getRealPath();   //临时文件的绝对路径
            $datapath = date('Y-m-d', time());//每日为一个文件夹
            $Path = public_path() . "/admin/uploads/Protype/";//上传路径

            //文件夹不存在就创建
            if (!file_exists($Path)) {
                mkdir($Path);
            }
            if (!file_exists($Path . $datapath)) {
                mkdir($Path . $datapath);
            }

            $filename = time() . '_' . uniqid() . '.' . $ext;//文件名
            //执行上传
            $res = move_uploaded_file($realPath, $Path . $datapath . '/' . $filename);
            //判断上传结果并返回信息
            if ($res) {
                //判断是否有旧图片,有的话就删除
                $old_pic = public_path().$request->get('old_logo');
                if(!empty($request->get('old_logo')) && file_exists($old_pic)){
                    unlink($old_pic);
                }

                //删除数据库中的logo路径,更新新的图片信息
                $save = Protype::find($request->get('Protype_id'));
                if($save){
                    $save->Protype_logo = "/admin/uploads/Protype/" . $datapath . '/' . $filename;
                    $save->save();
                }


                //成功之后组装返回数据
                $data = [
                    'status' => '1',
                    'msg' => '图片上传成功!',
                    'url' => "/admin/uploads/Protype/" . $datapath . '/' . $filename
                ];
            } else {
                //失败组装返回数据
                $data = [
                    'status' => '2',
                    'msg' => '图片上传失败!',
                    'url' => ''
                ];
            }
        } else {//不合法
            $data = [
                'status' => '3',
                'msg' => '图片不合法!',
                'url' => ''
            ];
        }
        echo json_encode($data);
    }

    /* @fun: 修改专业分类的显示页面
     * @author: fanzhiyi
     * @date: 2017/7/10 11:37
     * @param: $id 要修改的专业分类id
     * @return:
     */
    public function edit($id,Request $request)
    {
        if($request->isMethod('get')){
            //获取要修改的这条数据
            $data = Protype::find($id);

            //返回数据并显示页面
            return view('admin.Protype.edit')->with('edit',$data);
        }

        if($request->isMethod('post')){
            //获取准备更新的数据
            $input = $request->only(['Protype_name','Protype_site','Protype_logo','description']);

            //执行更新操
            $res = Protype::where('id','=',$id)->update($input);

            //返回执行结果
            if($res){
                echo "<script type='text/javascript'>
                alert('success!');
                var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                parent.location.reload(); // 父页面刷新
                parent.layer.close(index);//关闭当前弹出层
                </script>";
            } else {
                return back()->withErrors('failed!');
            }
        }
    }

}
