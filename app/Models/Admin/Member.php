<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;
    //指定表名,否则lavarel会自动在操作表的时候自动加上s
    protected $table = 'member';

    //指定表的白名单字段
    protected $fillable = ['username','password','gender','mobile','email','avatar','type','status','remark','created_at','updated_at'];
}
