<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建权限表
        Schema::create('auth',function($table){
            $table -> increments('id');
            $table -> string('auth_name',20)->notnull()->comment('权限名称');
            $table -> string('controller',40)->notnull()->comment('控制器');
            $table -> string('action',30)->notnull()->comment('方法');
            $table -> tinyInteger('pid')->notnull()->comment('父级id,0表示最高权限');
            $table -> enum('is_nav',[1,2])->notnull()->default('1')->comment('是否显示菜单,1显示,2不显示');
            $table -> timestamps();
            $table -> softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //删除表
        Schema::dropIfExists('auth');
    }
}
