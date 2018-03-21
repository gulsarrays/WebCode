<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
        			'name' => 'Ad Admin',
        			'slug' => 'ad-admin',
        			'permission' => 'create-ad',
        			'is_active' => 1,
        			'created_at' => Carbon::now()
                ]);
    }
}
