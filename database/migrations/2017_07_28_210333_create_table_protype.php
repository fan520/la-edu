<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProtype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建专业分类表
        Schema::create('protype', function (Blueprint $table) {
            $table->increments('id');
            $table->string('protype_name', 32)->notNull()->comment('专业名称');//专业名称
            $table->tinyInteger('sort')->notNull()->default('50')->comment('排序');//专业排序
            $table->enum('status', [1, 2])->notNull()->default('1')->comment('状态,1启用,2禁用');//专业状态
            $table->string('remark')->notNull()->default('')->comment('备注');//备注
            $table->tinyInteger('pid')->notNull()->default('0')->comment('父级分类id');//父级id
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
        //删除专业分类表
        Schema::dropIfExists('protype');
    }
}
