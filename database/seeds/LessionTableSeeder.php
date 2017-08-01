<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
class LessionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //填充课时表数据
        DB::table('lession')->insert([
            'lession_name' => 'Linux大神之路第一课时',
            'course_id' => '2',
            'cover_img' => 'http://otsvb3m6e.bkt.clouddn.com/avatar_2017-07-28_1501246147707.jpg',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('lession')->insert([
            'lession_name' => 'redisv好深第一课时',
            'course_id' => '3',
            'cover_img' => 'http://otsvb3m6e.bkt.clouddn.com/avatar_2017-07-28_1501246147707.jpg',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('lession')->insert([
            'lession_name' => '王者荣耀大神之路第一课时',
            'course_id' => '1',
            'cover_img' => 'http://otsvb3m6e.bkt.clouddn.com/avatar_2017-07-28_1501246147707.jpg',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
