<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Brand extends Model
{
    //使用假删除
    use SoftDeletes;

    //指定表名
    protected $table = 'brand';

    //添加新增字段白名单
    protected $fillable = ['brand_name','brand_site','brand_logo','description'];

    /* @fun: 增加数据的验证
     * @author: fanzhiyi
     * @date: 2017/7/8 11:12
     * @param: $input 要验证的数据数组
     * @return: $errors
     */
    public function storeValidator($input)
    {
        //自定义验证规则
        $rules = [
            'brand_name' => 'required|unique:brand,brand_name',
            'brand_site' => 'url'
        ];

        //自定义错误提示信息
        $mess = [
            'brand_name.required' => '品牌不能为空!',
            'brand_name.unique' => '品牌已经存在!',
            'brand_site.url' => 'site不合法!',
        ];

        //执行验证,并返回验证结果
        return Validator::make($input,$rules,$mess);
    }



}
