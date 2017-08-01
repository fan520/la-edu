<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lession extends Model
{
    //使用假删除
    use SoftDeletes;

    //指定表名
    protected $table = 'lession';

    //添加新增字段白名单
    protected $fillable = ['lession_name','course_id','cover_img','video_time','video_addr','sort','status','description'];
}
