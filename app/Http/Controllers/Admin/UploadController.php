<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /* @fun: 文件上传到本地
     * @author: fanzhiyi
     * @date: 2017/7/26 17:08
     * @param:
     * @return:
     */
    public function localPublic(Request $request)
    {
        //判断文件合法性
        if($request->hasFile('file') && $request->file('file')->isValid()){
            //获取图片后缀
            $extension = $request->file('file')->getClientOriginalExtension();

            //自定义文件名
            $name = 'avatar_'.date('Y-m-d').'_'.time().rand(111,999);

            //拼接新的文件名
            $filename = $name.'.'.$extension;

            //获取客户端路径
            $originpathname = File::get($request->file('file')->getRealPath());

            //执行上传图片
            $res = Storage::disk('public')->put($filename,$originpathname);

            //判断并返回结果
            if($res){
                return [
                    'status' => 1,
                    'msg' => 'avatar uploaded success!',
                    'filepath' => '/storage/'.$filename
                ];
            }else{
                return [
                    'status' => 2,
                    'msg' => 'uploaded failed!',
                ];
            }
        }else{
            return [
                'status' => 2,
                'msg' => 'uploaded failed!',
            ];
        }
    }

    /* @fun: 七牛云上传
     * @author: fanzhiyi
     * @date: 2017/7/28 20:32
     * @param:
     * @return:
     */
    public function qiniu(Request $request)
    {
        //判断文件合法性
        if($request->hasFile('file') && $request->file('file')->isValid()){
            //获取图片后缀
            $extension = $request->file('file')->getClientOriginalExtension();

            //自定义文件名
            $name = 'avatar_'.date('Y-m-d').'_'.time().rand(111,999);

            //拼接新的文件名
            $filename = $name.'.'.$extension;

            //获取客户端路径
            $originpathname = File::get($request->file('file')->getRealPath());

            //执行上传图片
            $disk = \Storage::disk('qiniu');
            $res = $disk->put($filename,$originpathname);//上传文件

            //判断并返回结果
            if($res){
                return [
                    'status' => 1,
                    'msg' => 'avatar uploaded success!',
                    'filepath' => $disk->getDriver()->downloadUrl($filename)                //获取下载地址
                ];
            }else{
                return [
                    'status' => 2,
                    'msg' => 'avatar uploaded failed!',
                ];
            }
        }else{
            return [
                'status' => 2,
                'msg' => 'avatar uploaded failed!',
            ];
        }
    }




}
