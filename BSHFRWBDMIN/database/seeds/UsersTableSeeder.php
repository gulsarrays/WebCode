<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_admin')->delete();
        DB::table('users_admin')->insert([
                #'name' => 'Super Admin',
                'username'=>'superadmin',
                'email'    => 'superadmin@compass.in',
                'password' => md5('admin123'),
                'mobile_number' => '9900001201',
                #'gender' => 'Male',
                'user_type' => 1,
                'is_active' => 1
                ]);
        DB::table('users_admin')->insert([
                #'name' => 'Talisman',
                'username'=>'admin',
                'email'    => 'admin@compass.in',
                'password' => md5('admin123'),
                'mobile_number' => '9900001200',
                #'gender' => 'Male',
                'user_type' => 2,
                'is_active' => 1
                ]);
    }
}
