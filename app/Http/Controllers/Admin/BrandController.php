<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    /* @fun: 品牌列表展示
     * @author: fanzhiyi
     * @date: 2017/7/7 11:26
     * @param:
     * @return:
     */
    public function index()
    {
        return view('admin.brand.index');
    }

    /* @fun: 获取品牌数据
     * @author: fanzhiyi
     * @date: 2017/7/8 16:37
     * @param:
     * @return:
     */
    public function getList(Request $request)
    {
        $pagesize = $request->get('pageSize');
        $pagestart = $request->get('page') - 1;
        $offset = $pagestart * $pagesize;

        //拼接查询条件
        $query = Brand::query();//查询对象
        //开始时间
        if ($start = $request->get('updated_start')) {
            $query->where('updated_at', '>', $start);
        }
        //终止时间
        if ($end = $request->get('updated_end')) {
            $query->where('updated_at', '<', $end);
        }
        if ($brand_name = $request->get('brand_name')) {
            $query->where('brand_name', 'LIKE', '%' . $brand_name . '%');
        }
        $data = $query->offset($offset)->limit($pagesize)->get()->toArray();

        return [
            'draw' => $request->get('draw'),
            'recordsFiltered' => $query->count(),//被检索后的数量
            'recordsTotal' => $query->count(),//总记录数
            'data' => $data//返回的数据
        ];
    }

    /* @fun: 添加品牌
     * @author: fanzhiyi
     * @date: 2017/7/7 15:04
     * @param:
     * @return:
     */
    public function create()
    {
        return view('admin/brand/add');
    }

    /* @fun: 添加的品牌的处理
     * @author: fanzhiyi
     * @date: 2017/7/8 11:01
     * @param:
     * @return:
     */
    public function store(Request $request)
    {
        //接受入库的数据
        $data['brand_name'] = $request->get('brand_name');
        $data['brand_site'] = $request->get('brand_site');
        $data['brand_logo'] = $request->get('brand_logo');
        $data['description'] = $request->get('description');


        //执行验证
        if (empty($data)) {
            return back()->withErrors('请输入数据!');
        }

        $validator = (new Brand())->storeValidator($data);

        //判断验证结果
        if (!$validator->fails()) {
            //插入数据
            $res = Brand::create($data);
            if ($res) {
                echo "<script type='text/javascript'>
                alert('添加成功!');
                var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                parent.location.reload(); // 父页面刷新
                parent.layer.close(index);//关闭当前弹出层
                </script>";
            } else {
                echo "<script type='text/javascript'>alert('添加失败!');window.location.href='admin/login';</script>";
            }
        } else {
            return back()->withErrors($validator);
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

        Brand::whereIn('id',$ids)->get()->each(function($i){
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
        $res = Brand::where('id','=',$id)->delete();
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
            $Path = public_path() . "/admin/uploads/brand/";//上传路径

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
                $save = Brand::find($request->get('brand_id'));
                $save->brand_logo = "/admin/uploads/brand/" . $datapath . '/' . $filename;
                $save->save();

                //成功之后组装返回数据
                $data = [
                    'status' => '1',
                    'msg' => '图片上传成功!',
                    'url' => "/admin/uploads/brand/" . $datapath . '/' . $filename
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

    /* @fun: 修改品牌的显示页面
     * @author: fanzhiyi
     * @date: 2017/7/10 11:37
     * @param: $id 要修改的品牌id
     * @return: 
     */
    public function edit($id)
    {
        //获取要修改的这条数据
        $data = Brand::find($id);

        //返回数据并显示页面
        return view('admin.brand.edit')->with('edit',$data);
    }

    /* @fun: 保存修改的数据
     * @author: fanzhiyi
     * @date: 2017/7/10 15:59
     * @param:
     * @return:
     */
    public function update(Request $request)
    {
        //获取准备更新的数据
        $id = $request->get('id');
        $input = $request->only(['brand_name','brand_site','brand_logo','description']);

        //执行更新操
        $res = Brand::where('id','=',$id)->update($input);

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
