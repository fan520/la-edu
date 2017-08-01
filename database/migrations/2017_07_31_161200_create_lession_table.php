<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建课时表
        Schema::create('lession', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lession_name', 50)->notnull()->comment('课时名称');
            $table->integer('course_id')->notnull()->comment('课程id');
            $table->string('cover_img')->notnull()->default('')->comment('封面地址');
            $table->integer('video_time')->notnull()->default('0')->comment('视频时长');
            $table->string('video_addr')->notnull()->default('')->comment('视频地址');
            $table->integer('sort')->notnull()->default('0')->comment('排序');
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
        //删除课时表
        Schema::dropIfExists('lession');
    }
}
