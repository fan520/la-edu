<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProfession extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建专业表
        Schema::create('profession',function(Blueprint $table){
            $table->increments('id');
            $table->string('pro_name',20)->notnull()->comment('专业名称');//专业名称
            $table->tinyInteger('protype_id')->notnull()->comment('所属分类id');//所属分类
            $table->string('teachers_ids',255)->notnull()->default('')->comment('任课老师集合id');//任课老师集合热id
            $table->string('cover_img',255)->notnull()->default('')->comment('封面图片地址');//封面图片地址
            $table->string('ppt_imgs',255)->notnull()->default('')->comment('幻灯片地址');//幻灯片地址
            $table->integer('view_count')->notnull()->default('500')->comment('浏览量');//浏览量
            $table->tinyInteger('sort')->notnull()->default('50')->comment('排序');//排序
            $table->tinyInteger('duration')->notnull()->default('0')->comment('代课时长');//代课时长
            $table->decimal('price',7,2)->notnull()->default('1.00')->comment('专业价格');//专业价格
            $table->string('description')->notnull()->default('')->comment('描述');//描述
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
        //删除专业表
        Schema::dropIfExists('profession');
    }
}
