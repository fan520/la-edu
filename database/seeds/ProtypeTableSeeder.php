<?php

use Illuminate\Database\Seeder;
use  \Illuminate\Support\Facades\DB;

class ProtypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        //使用工厂模式添加测试数据
//        $faker = \Faker\Factory::create('zh_CN');

        //插入测试数据
        DB::table('protype')->insert([
            'protype_name' => 'PHP',//分类名称
            'status' => rand(1,2),//状态
            'pid' => 0,//父级id
            'created_at' => date('Y-m-d H:i;s'),
        ]);

        DB::table('protype')->insert([
            'protype_name' => 'JAVA',//分类名称
            'status' => rand(1,2),//状态
            'pid' => 0,//父级id
            'created_at' => date('Y-m-d H:i;s'),
        ]);

        DB::table('protype')->insert([
            'protype_name' => 'WEB',//分类名称
            'status' => rand(1,2),//状态
            'pid' => 0,//父级id
            'created_at' => date('Y-m-d H:i;s'),
        ]);

    }
}
