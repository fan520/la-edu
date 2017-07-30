<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
class ProfessionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //专业表添加数据
        DB::table('profession')->insert([
            'pro_name' => 'DIV+CSS',
            'protype_id' => '7'
        ]);
        DB::table('profession')->insert([
            'pro_name' => 'H5',
            'protype_id' => '8'
        ]);
        DB::table('profession')->insert([
            'pro_name' => 'LINUX',
            'protype_id' => '9'
        ]);
        DB::table('profession')->insert([
            'pro_name' => 'RediS',
            'protype_id' => '10'
        ]);
    }
}
