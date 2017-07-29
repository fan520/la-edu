<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class CheckRbac
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //获取当前请求的方法
        $action = strtolower(Route::currentRouteAction());
        $route = explode('\\',$action);
        $route = end($route);//比如managecontroller@index

        //获取当前登陆者的角色所拥有的权限
        $role = explode(',',Auth::guard('admin')->user()->admin_role()->first()->auth_ac);

        //超级管理员绕过权限验证
        if(Auth::guard('admin')->user()->admin_role()->first()->role_name == '超级管理员'){
            return $next($request);
        }

        //默认全部用户都有后台首页的权限
        array_push($role,'admincontroller@index','admincontroller@welcome','admincontroller@logout');
        if(!in_array($route,$role)){
            echo "对不起,您没有权限!";exit;
        }else{
            return $next($request);
        }
    }
}
