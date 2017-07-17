<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');

});

/*后台路由*/
//后台登陆
Route::match(['get','post'],'admin/login','Admin\LoginController@login')->name('login');

//后台登陆后才能访问的路由
Route::group(['middleware' => 'auth:admin','namespace' => 'Admin','prefix' => 'admin'],function(){
    //后台首页
    Route::get('index','AdminController@index');

    //退出
    Route::get('logout','AdminController@loginOut');

    //后台欢迎页面
    Route::get('welcome','AdminController@welcome');


    //*--管理员RBACstart--*//
    Route::resource('manage','ManageController');//管理员资源路由
    Route::post('manage/getList','ManageController@getList');//获取管理员列表数据
    Route::post('manage/batchDel','ManageController@batchDel');//批量删除管理员
    //*--管理员end--*//


    //*--角色RBACstart--*//
    //Route::resource('role','RoleController');//角色资源路由
    Route::match(['get','post'],'role/add','RoleController@add');//添加角色(增)
    Route::post('role/del','RoleController@del');//批量删除角色(删)
    Route::match(['get','post'],'role/edit/{id}','RoleController@edit');//编辑角色(改)
    Route::match(['get','post'],'role/index','RoleController@index');//角色列表和查询角色(查)
    Route::get('role/allocate_auth/{id}','RoleController@allocate_auth');//角色权限分配
    //*--角色end--*//


    //*--权限RBACstart--*//
    Route::resource('auth','AuthController');//权限资源路由
    Route::post('auth/getList','AuthController@getList');//获取权限列表数据
    Route::post('auth/batchDel','AuthController@batchDel');//批量删除权限
    //*--权限end--*//


    //*--品牌start--*//
    Route::resource('brand','BrandController');//品牌资源路由
    Route::post('brand/logo','BrandController@logo');//品牌logo路由
    Route::post('brand/getList','BrandController@getList');//获取品牌列表数据
    Route::post('brand/batchDel','BrandController@batchDel');//批量删除品牌
    //*--品牌end--*//

});
