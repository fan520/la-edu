<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建会员表
        Schema::create('member',function(Blueprint $table){
            $table -> increments('id');
            $table -> string('username',20) -> notNull() -> comment('会员名');
            $table -> string('password',255) -> notNull() -> comment('密码');
            $table -> enum('gender',[1,2,3]) -> notNull() ->default(3) -> comment('性别,1男,2女,3保密');
            $table -> string('mobile',11) -> notNull() ->default('') -> comment('手机号码');
            $table -> string('email',40) -> notNull() ->default('') -> comment('邮箱');
            $table -> string('avatar') -> notNull() ->default('') -> comment('头像地址');
            $table -> enum('type',[1,2]) -> notNull() ->default(1) -> comment('账号类型,1学生,2老师');
            $table -> enum('status',[1,2]) -> notNull() ->default(1) -> comment('账号状态,1启用,2禁用');
            $table -> string('remark') -> notNull() ->default('') -> comment('备注信息');
            $table -> timestamps();
            $table -> rememberToken();
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
        //删除会员表
        Schema::dropIfExists('member');
    }
}
