<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //角色表
        Schema::create('role',function($table){
            $table -> increments('id');
            $table -> string('role_name',20)->notnull()->unique()->comment('角色名称');
            $table -> string('auth_ids')->comment('权限id集合');
            $table -> string('auth_ac')->comment('对应权限控制器和方法的集合');
            $table -> timestamps();
            $table -> SoftDeletes();
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
        Schema::dropIfExists('role');
    }
}
