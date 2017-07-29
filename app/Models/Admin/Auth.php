<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Auth extends Model
{
    //使用假删除
    use SoftDeletes;

    //表名
    protected $table = 'Auth';

    //禁用自动添加时间戳
    //public $timestamps = false;

    //允许操作的字段
    protected $fillable = ['auth_name','controller','action','pid','is_nav'];
}
