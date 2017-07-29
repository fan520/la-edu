<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Admin;
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
            //验证提交的数据
            $this->validate($request, [
                'username' => 'required|min:4|max:20',
                'password' => 'required|min:5|max:32',
                'captcha' => 'required|size:5|captcha',
            ]);

            //获取数据
            $input = $request -> only(['username','password']);

            //尝试去验证,并且实现记住我功能
            $result = Auth::guard('admin') -> attempt($input,$request->get('online'));

            //判断登陆结果
            if($result){
                return redirect('admin/admin/index');
            } else {
                return back()->withErrors(['loginError' => '用户名或者密码错误!']);
            }
        }
    }

    /* @fun: 退出
     * @author: fanzhiyi
     * @date: 2017/7/14 14:15
     * @param:
     * @return:
     */
    public function logOut()
    {
        Auth::guard('admin')->logout();
    }



}
