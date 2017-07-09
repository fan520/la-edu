<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /* @fun: 后台首页
     * @author: fanzhiyi
     * @date: 2017/7/7 10:57
     * @param:
     * @return:
     */
    public function index()
    {
        return view('admin.index.index');
    }

    /* @fun: 后台欢迎页面
     * @author: fanzhiyi
     * @date: 2017/7/7 11:16
     * @param:
     * @return:
     */
    public function welcome()
    {
        return view('admin.index.welcome');
    }

    /* @fun: 退出
     * @author: fanzhiyi
     * @date: 2017/7/9 18:27
     * @param:
     * @return:
     */
    public function loginOut()
    {
        Auth::logout();
        return redirect('admin/login');
    }
}
