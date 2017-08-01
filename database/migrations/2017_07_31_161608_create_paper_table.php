<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建试卷表
        Schema::create('paper',function(Blueprint $table){
            $table->increments('id');
            $table->string('paper_name', 50)->notnull()->comment('试卷名称');
            $table->integer('course_id')->notnull()->comment('课程id');
            $table->tinyInteger('score')->notnull()->default('100')->comment('得分');
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
        //删除试卷表
        Schema::dropIfExists('paper');
    }
}
