<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paper extends Model
{
    //使用假删除
    use SoftDeletes;

    //指定表名
    protected $table = 'paper';

    //添加新增字段白名单
    protected $fillable = ['paper_name','course_id','score','sort','status','description'];
}
