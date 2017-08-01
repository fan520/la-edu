<?php

use Illuminate\Database\Seeder;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //填充试题表数据
        DB::table('question')->insert([
            'question' => '一只青蛙几只眼?',
            'paper_id' => '1',
            'score' => '50',
            'options' => 'A.1,B.2,C.3,D.4',
            'answer' => 'B',
            'remark' => 'test',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('question')->insert([
            'question' => '两只青蛙几只眼?',
            'paper_id' => '1',
            'score' => '50',
            'options' => 'A.1,B.2,C.3,D.4',
            'answer' => 'D',
            'remark' => 'test',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
