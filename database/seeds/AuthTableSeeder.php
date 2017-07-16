<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
class AuthTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //数据填充
        DB::table('auth')->insert([
        'auth_name' => '品牌管理',
        'controller' => 'Brand',
        'action' => '',
        'pid' => '0',
        'is_nav' => '1',
        'created_at' => date('Y-m-d H:i:s'),
    ]);

        DB::table('auth')->insert([
            'auth_name' => '品牌删除',
            'controller' => 'Brand',
            'action' => 'destory',
            'pid' => '1',
            'is_nav' => '1',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('auth')->insert([
            'auth_name' => '品牌添加',
            'controller' => 'Brand',
            'action' => 'store',
            'pid' => '1',
            'is_nav' => '1',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('auth')->insert([
            'auth_name' => '用户管理',
            'controller' => 'Manage',
            'action' => '',
            'pid' => '0',
            'is_nav' => '1',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('auth')->insert([
            'auth_name' => '用户删除',
            'controller' => 'Manage',
            'action' => 'destory',
            'pid' => '1',
            'is_nav' => '1',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('auth')->insert([
            'auth_name' => '品牌添加',
            'controller' => 'Manage',
            'action' => 'store',
            'pid' => '1',
            'is_nav' => '1',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
