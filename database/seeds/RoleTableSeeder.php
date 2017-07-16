<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert([
            'role_name' => '超级管理员',
            'auth_ids' => '4,5,6,7',
            'auth_ac' => 'BrandController@index,BrandController@create,BrandController@edit,BrandController@update',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('role')->insert([
            'role_name' => '财务主管',
            'auth_ids' => '4,5,6,7',
            'auth_ac' => 'RoleController@index,RoleController@create,RoleController@edit,RoleController@update',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('role')->insert([
            'role_name' => '行政助理',
            'auth_ids' => '4,5,6,7',
            'auth_ac' => 'ManageController@index,ManageController@create,ManageController@edit,ManageController@update',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
