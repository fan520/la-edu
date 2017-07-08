<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class Users extends Model
{
    //指定表名
    protected $table = "users";

    //指定可以批量填充的字段
    protected $fillable = ['name','password','email','created_at','updated_at'];

    /* @fun: 用户登录验证
     * @author: fanzhiyi
     * @date: 2017/7/7 9:43
     * @param:
     * @return:
     */
    public function Validator($input)
    {
        //自定义验证规则
        $rules = [
            'name' => 'required',//非空
            'password' => 'required',//非空
            'captcha' => 'required|captcha'//非空,验证码规则
        ];

        //验证错误提示信息
        $mess = [
            'name.required' => '用户名不能为空!',
            'password.required' => '密码不能为空!',
            'captcha.required' => '验证码不能为空!',
            'captcha.captcha' => '验证码有误!',
        ];

        //执行验证
        return Validator::make($input,$rules,$mess);
    }
}
