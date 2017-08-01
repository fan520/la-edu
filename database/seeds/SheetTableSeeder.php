<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
class SheetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //填充答题表数据
        DB::table('sheet')->insert([
            'paper_id' => '1',
            'question_id' => '1',
            'member_id' => '1',
            'is_corrent' => '1',
            'score' => '50',
            'answer' => 'B',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('sheet')->insert([
            'paper_id' => '1',
            'question_id' => '2',
            'member_id' => '1',
            'is_corrent' => '1',
            'score' => '50',
            'answer' => 'D',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
