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

    //指定不可以被修改的字段
    protected $guarded = ['id'];

    /* @fun: 关联测试
     * @author: fanzhiyi
     * @date: 2017/7/16 13:48
     * @param:
     * @return:
     */
    public function admin_role()
    {
        return $this->hasOne('App\Models\Admin\Role','id','role_id');//('关联模型','关联模型字段','当前表与关联表的关联字段')
    }

}
