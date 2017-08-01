<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sheet extends Model
{
    //使用假删除
    use SoftDeletes;

    //指定表名
    protected $table = 'Sheet';

    //添加新增字段白名单
    protected $fillable = ['brand_name','brand_site','brand_logo','description'];
}
