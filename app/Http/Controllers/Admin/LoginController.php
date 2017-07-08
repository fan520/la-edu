<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if($request->isMethod('get')){
            return view('admin.login.login');
        }elseif($request->isMethod('post')){
            $users = new Users();
            $input = $request->except('_token');//除了_token字段的数据
            $remember = $request->has('online');//是否存在online字段,存在返回true,否则返回false
            $validator = $users->Validator($input);
            if(!$validator->fails()){
                //执行登陆判断,登陆成功返回1并记录登陆信息,登陆失败返回0
                $login = Auth::attempt(['name'=>$request->get('name'),'password'=>$request->get('password')],$remember);
                if($login){
                    return redirect('admin/index');
                }else{
                    return back()->withErrors('用户名或者密码错误!');
                }
            }else{
                return back()->withErrors($validator);
            }
        }

    }
}
