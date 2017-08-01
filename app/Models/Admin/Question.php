<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //使用假删除
    use SoftDeletes;

    //指定表名
    protected $table = 'question';

    //添加新增字段白名单
    protected $fillable = ['question','paper_id','score','options','answer','remark'];
}
