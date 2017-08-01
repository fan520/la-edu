<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建答题表
        Schema::create('sheet',function(Blueprint $table){
            $table->increments('id');
            $table->tinyInteger('paper_id')->notnull()->comment('试卷id');
            $table->tinyInteger('question_id')->notnull()->comment('关联试题id');
            $table->tinyInteger('member_id')->notnull()->comment('用户id');
            $table->enum('is_corrent',[1,2])->notnull()->default('2')->comment('是否答对,1对,2错');
            $table->tinyInteger('score')->notnull()->default('0')->comment('本题用户得分');
            $table->string('answer')->notnull()->default('')->comment('用户答案');
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
        //删除答题表
        Schema::dropIfExists('sheet');
    }
}
