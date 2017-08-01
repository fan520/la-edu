<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    //使用假删除
    use SoftDeletes;

    //指定表名
    protected $table = 'Course';

    //添加字段白名单
    protected $fillable = ['course_name','profession_id','cover_img','sort','status','description'];
}
