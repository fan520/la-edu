<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Protype extends Model
{
    //引入假删除
    use SoftDeletes;

    //指定表名,否则每次请求的时候都会自动子表名后面加上s
    protected $table = 'protype';

    //白名单(新增数据的时候,下面这些字段是可以插入的)
    protected $fillable =['protype_name','sort','pid','status','remark'];

    //黑名单


//    /* @fun:根据pid获取专业分类名称
//     * @author: fanzhiyi
//     * @date: 2017/7/29 22:33
//     * @param: $pid
//     * @return: $string
//     */
//    public static function getProNameByPid($pid = '')
//    {
//        //空pid返回空数据
//        if(!$pid){
//            return '';
//        }
//
//        //非空pid返回数据
//        return DB::table('protype')->where('id', $pid)->first()->protype;
//    }
}
