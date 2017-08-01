<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建课程表
        Schema::create('course', function (Blueprint $table) {
            $table->increments('id');
            $table->string('course_name', 30)->notnull()->comment('课程名称');
            $table->integer('profession_id')->notnull()->comment('专业id');
            $table->string('cover_img')->notnull()->default('')->comment('封面地址');
            $table->integer('sort')->notnull()->default('50')->comment('排序');
            $table->enum('status', [1, 2])->notnull()->default('2')->comment('课程状态,1启用,2禁用');
            $table->string('description')->notnull()->default('')->comment('描述');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //删除课程表
        Schema::dropIfExists('course');
    }
}
