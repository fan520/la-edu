<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建试题表
        Schema::create('question',function(Blueprint $table){
            $table -> increments('id');
            $table->text('question')->notnull()->default('')->comment('试题内容');
            $table->tinyInteger('paper_id')->notnull()->comment('关联试卷id');
            $table->tinyInteger('score')->notnull()->default('0')->comment('该题分数');
            $table->string('options',255)->notnull()->default('0')->comment('选项内容');
            $table->string('answer')->notnull()->comment('正确答案');
            $table->string('remark')->notnull()->default('')->comment('备注');
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
        //删除试题表
        Schema::dropIfExists('question');
    }
}
