<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Request;

class Admin extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    use Authenticatable;
    //指定表名
    protected $table = 'admin';
    //指定可以填充的字段白名单
    protected $fillable = ['username','password','gender','mobile','email','role_id','status'];


}
