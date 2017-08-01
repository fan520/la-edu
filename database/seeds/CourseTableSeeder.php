<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //课程表填充数据
        DB::table('course')->insert([
            'course_name' => 'Linux大神之路',
            'profession_id' => '1',
            'cover_img' => 'http://otsvb3m6e.bkt.clouddn.com/avatar_2017-07-28_1501246147707.jpg',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('course')->insert([
            'course_name' => 'redisv好深',
            'profession_id' => '2',
            'cover_img' => 'http://otsvb3m6e.bkt.clouddn.com/avatar_2017-07-28_1501246147707.jpg',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('course')->insert([
            'course_name' => '王者荣耀大神之路',
            'profession_id' => '1',
            'cover_img' => 'http://otsvb3m6e.bkt.clouddn.com/avatar_2017-07-28_1501246147707.jpg',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
