<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //创建模拟数据
        $faker = \Faker\Factory::create('zh_CN');
        for($i = 0;$i < 100;$i++){
            DB::table('member')->insert([
                'username' => $faker -> userName,//用户名
                'password' => bcrypt('123456'),//密码
                'gender' => rand(1,3),//性别
                'mobile' => $faker->phoneNumber,//手机号
                'avatar' => '/storage/avatar_2017-07-27_1501135963507.jpg',//头像地址
                'email' => $faker->email(40),//邮箱
                'created_at' => date('Y-m-d'),//创建日期
                'type' => rand(1,2),//账号类型
                'status' => rand(1,2),//账号状态
            ]);
        }
    }
}
