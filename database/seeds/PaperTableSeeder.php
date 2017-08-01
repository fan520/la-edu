<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
class PaperTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //试卷表填充数据
        DB::table('paper')->insert([
            'paper_name' => 'Linux第1套卷',
            'course_id' => '2',
            'score' => rand(1,100),
            'sort' => rand(1,100),
            'score' => rand(1,100),
            'status' => rand(1,2),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('paper')->insert([
            'paper_name' => 'Linux第2套卷',
            'course_id' => '1',
            'score' => rand(1,100),
            'sort' => rand(1,100),
            'score' => rand(1,100),
            'status' => rand(1,2),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('paper')->insert([
            'paper_name' => 'redis第1套卷',
            'course_id' => '2',
            'score' => rand(1,100),
            'sort' => rand(1,100),
            'score' => rand(1,100),
            'status' => rand(1,2),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('paper')->insert([
            'paper_name' => '王者荣耀第1套卷',
            'course_id' => '3',
            'score' => rand(1,100),
            'sort' => rand(1,100),
            'score' => rand(1,100),
            'status' => rand(1,2),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
