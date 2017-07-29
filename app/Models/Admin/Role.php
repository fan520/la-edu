<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Role extends Model
{
    use SoftDeletes;
    //表名
    protected $table = 'Role';

    //禁用自动添加时间戳(更新时间和修改时间)
    //public $timestamps = false;

    //白名单
    protected $fillable = ['role_name','auth_ids','auth_ac'];

    //黑名单
    //protected $guarded = [];

    //主键
    protected $primaryKey = 'id';

    /* @fun: 根据角色id获取角色名称
     * @author: fanzhiyi
     * @date: 2017/7/18 16:58
     * @param: $id
     * @return: $role_name
     */
    public static function getRoleNameById($id='')
    {
        if($id){
             return Admin::where('id',$id)->select('role_name')->first()->role_name;
        }else{
            return '';
        }
    }
}
