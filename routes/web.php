<?php
Route::get('/', function () {
    return view('welcome');
});

/*后台路由*/
//后台登陆
Route::match(['get','post'],'admin/login','Admin\LoginController@login')->name('login');

//后台登陆后才能访问的路由
Route::group(['middleware' => ['auth:admin','checkrbac'],'namespace' => 'Admin','prefix' => 'admin'],function(){
    //后台首页
    Route::get('admin/index','AdminController@index');
    Route::get('admin/logout','AdminController@logOut');//退出登陆
    Route::get('admin/welcome','AdminController@welcome');//后台欢迎页面


    //*--管理员RBACstart--*//
    Route::match(['get','post'],'manage/add','ManageController@add');//添加角色(增)
    Route::post('manage/del','ManageController@del');//批量删除角色(删)
    Route::match(['get','post'],'manage/edit/{id}','ManageController@edit');//编辑角色(改)
    Route::match(['get','post'],'manage/index','ManageController@index');//角色列表和查询角色(查)
    //*--管理员end--*//


    //*--角色RBACstart--*//
    Route::match(['get','post'],'role/add','RoleController@add');//添加角色(增)
    Route::post('role/del','RoleController@del');//批量删除角色(删)
    Route::match(['get','post'],'role/edit/{id}','RoleController@edit');//编辑角色(改)
    Route::match(['get','post'],'role/index','RoleController@index');//角色列表和查询角色(查)
    //*--角色end--*//


    //*--权限RBACstart--*//
    Route::match(['get','post'],'auth/add','AuthController@add');//添加权限(增)
    Route::post('auth/del','AuthController@del');//批量删除权限(删)
    Route::match(['get','post'],'auth/edit/{id}','AuthController@edit');//编辑权限(改)
    Route::match(['get','post'],'auth/index','AuthController@index');//权限列表和查询权限(查)
    //*--权限end--*//


    //*--会员RBACstart--*//
    Route::match(['get','post'],'member/add','MemberController@add');//添加权限(增)
    Route::post('member/del','MemberController@del');//批量删除权限(删)
    Route::match(['get','post'],'member/edit/{id}','MemberController@edit');//编辑权限(改)
    Route::match(['get','post'],'member/index','MemberController@index');//权限列表和查询权限(查)
    //*--会员end--*//

    //文件上传
    Route::post('upload/localpublic','UploadController@localPublic');//图片上传到本服务器
    Route::post('upload/qiniu','UploadController@qiniu');//图片上传到七牛云

    //*--专业分类start--*//
    Route::match(['get','post'],'protype/add','ProtypeController@add');//添加分类(增)
    Route::post('protype/del','ProtypeController@del');//批量删除分类(删)
    Route::match(['get','post'],'protype/edit/{id}','ProtypeController@edit');//编辑分类(改)
    Route::match(['get','post'],'protype/index','ProtypeController@index');//分类列表和查询分类(查)
    //*--专业分类end--*//


    //*--课程管理start--*//
    Route::match(['get','post'],'course/add','CourseController@add');//添加课程(增)
    Route::post('course/del','CourseController@del');//批量删除课程(删)
    Route::match(['get','post'],'course/edit/{id}','CourseController@edit');//编辑课程(改)
    Route::match(['get','post'],'course/index','CourseController@index');//课程列表和查询分类(查)
    //*--课程管理end--*//

    //*--课时管理start--*//
    Route::match(['get','post'],'lession/add','LessionController@add');//添加课时(增)
    Route::post('lession/del','LessionController@del');//批量删除课时(删)
    Route::match(['get','post'],'lession/edit/{id}','LessionController@edit');//编辑课时(改)
    Route::match(['get','post'],'lession/index','LessionController@index');//课时列表和查询分类(查)
    //*--课时管理end--*//


    //*--专业start--*//
    Route::match(['get','post'],'profession/add','ProfessionController@add');//添加专业(增)
    Route::post('profession/del','ProfessionController@del');//批量删除专业(删)
    Route::match(['get','post'],'profession/edit/{id}','ProfessionController@edit');//编辑专业(改)
    Route::match(['get','post'],'profession/index','ProfessionController@index');//专业列表和查询分类(查)
    //*--专业end--*//

    //*--试卷start--*//
    Route::match(['get','post'],'paper/add','PaperController@add');//添加试卷(增)
    Route::match(['get','post'],'paper/import','PaperController@import');//添加试卷(增)
    Route::post('paper/del','PaperController@del');//批量删除试卷(删)
    Route::match(['get','post'],'paper/edit/{id}','PaperController@edit');//编辑试卷(改)
    Route::match(['get','post'],'paper/index','PaperController@index');//试卷列表和查询分类(查)
    //*--试卷end--*//

    //*--试题start--*//
    Route::match(['get','post'],'question/add','QuestionController@add');//添加试题(增)
    Route::match(['get','post'],'question/import','QuestionController@import');//导入试题(增)
    Route::match(['get','post'],'question/export','QuestionController@export');//导出试题(增)
    Route::post('question/del','QuestionController@del');//批量删除试题(删)
    Route::match(['get','post'],'question/edit/{id}','QuestionController@edit');//编辑试题(改)
    Route::match(['get','post'],'question/index','QuestionController@index');//试题列表和查询分类(查)
    //*--试题end--*//







    //*--品牌start--*//
    Route::match(['get','post'],'brand/add','BrandController@add');//添加权限(增)
    Route::post('brand/del','BrandController@del');//批量删除权限(删)
    Route::match(['get','post'],'brand/edit/{id}','BrandController@edit');//编辑权限(改)
    Route::match(['get','post'],'brand/index','BrandController@index');//权限列表和查询权限(查)
    Route::post('brand/logo','BrandController@logo');//批量删除权限(删)
    //*--品牌end--*//

});
