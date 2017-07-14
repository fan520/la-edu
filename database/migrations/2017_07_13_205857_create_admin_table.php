<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建admin表
        Schema::create('admin',function(Blueprint $table){
            //自增id
            $table->increments('id');
            //用户名字段
            $table->string('username')->notnull()->comment('用户名');
            //密码字段
            $table->string('password',255)->notnull()->comment('密码');
            //性别字段
            $table->enum('gender',[1,2,3])->notnull()->default('1')->comment('性别');
            //手机号
            $table->string('mobile',11)->notnull()->default('')->comment('手机号');
            //邮箱
            $table->string('email',40)->notnull()->default('')->comment('邮箱');
            //角色id
            $table->tinyInteger('role_id')->notnull()->comment('角色id');
            //增加时间&修改时间
            $table->timestamps();
            //记住用户登录状态
            $table->rememberToken();
            //用户状态字段
            $table->enum('status',[1,2])->notnull()->default('2')->comment('用户状态');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //删除admin表
        Schema::dropIfExists('admin');
    }
}
