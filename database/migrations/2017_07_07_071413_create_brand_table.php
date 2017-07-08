<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand',function(Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('brand_name')->notnull()->unique()->comment('品牌名称');
            $table->string('brand_site')->notnull()->default('')->comment('品牌站点');
            $table->string('brand_logo')->notnull()->default('')->comment('品牌logo');
            $table->string('description')->notnull()->default('')->comment('品牌描述');
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
        //
    }
}
