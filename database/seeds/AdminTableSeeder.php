<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('admin')->insert([
//            'username' => 'admin',
//            'password' => bcrypt('admin'),
//            'gender' => 1,
//            'mobile' => 15267898637,
//            'email' => '213125432@qq.com',
//            'role_id' => 1,
//            'created_at' => date('Y-m-d H:i:s'),
//            'status' => 1
//        ]);

        //引用faker框架中自带的快速生成数据的插件
        $faker = \Faker\Factory::create('zh_CN');
        //循环创建100条数据
        for ($i = 0;$i < 100;$i++) {
            DB::table('admin')->insert([
                'username' => $faker -> userName,
                'password' => bcrypt('123456'),
                'gender' => rand(1,3),
                'mobile' => $faker -> phoneNumber,
                'email' => $faker -> email(40),
                'role_id' => rand(1,5),
                'created_at' => date('Y-m-d H:i:s'),
                'status' => rand(1,2)

            ]);
        }
    }
}
