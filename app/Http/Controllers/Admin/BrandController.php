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
        $pagestart = $request->get('page')-1;
        $offset = $pagestart*$pagesize;
        $data = DB::table('brand')->offset($offset)->limit($pagesize)->get()->toArray();
        return [
            'draw' => $request->get('draw'),
            'recordsFiltered' => Brand::count(),//被检索后的数量
            'recordsTotal' => Brand::count(),//总记录数
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
        $data['created_at'] = date('Y-m-d H:i:s',time());
        $data['updated_at'] = date('Y-m-d H:i:s',time());

        //执行验证
        if (empty($data)) {
            return back()->withErrors('请输入数据!');
        }

        $validator = (new Brand())->storeValidator($data);

        //判断验证结果
        if (!$validator->fails()) {
            //插入数据
            $res = DB::table('brand')->insert($data);
            if ($res) {
                echo "<script type='text/javascript'>
                alert('添加成功!');
                var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                parent.layer.close(index);//关闭当前弹出层
                </script>";
            }
        } else {
            return back()->withErrors($validator);
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
                $data = [
                    'status' => '1',
                    'msg' => '图片上传成功!',
                    'url' => "/admin/uploads/brand/" . $datapath . '/' . $filename
                ];
            } else {
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


}
