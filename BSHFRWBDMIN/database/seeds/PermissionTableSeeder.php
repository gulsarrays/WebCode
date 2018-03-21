<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
        	[
        		'name' => 'role-list',
        		'display_name' => 'Display Role Listing',
        		'description' => 'See only Listing Of Role'
        	],
        	[
        		'name' => 'role-create',
        		'display_name' => 'Create Role',
        		'description' => 'Create New Role'
        	],
        	[
        		'name' => 'role-edit',
        		'display_name' => 'Edit Role',
        		'description' => 'Edit Role'
        	],
        	[
        		'name' => 'role-delete',
        		'display_name' => 'Delete Role',
        		'description' => 'Delete Role'
        	],
        	[
        		'name' => 'user-list',
        		'display_name' => 'Display User Listing',
        		'description' => 'See only Listing Of User'
        	],
        	[
        		'name' => 'user-create',
        		'display_name' => 'Create User',
        		'description' => 'Create New User'
        	],
        	[
        		'name' => 'user-edit',
        		'display_name' => 'Edit User',
        		'description' => 'Edit User'
        	],
        	[
        		'name' => 'user-delete',
        		'display_name' => 'Delete User',
        		'description' => 'Delete User'
        	],
            [
                'name' => 'others-section',
                'display_name' => 'Others section',
                'description' => 'To manage Category, Age Group and Gender under Others section'
            ],
            [
                'name' => 'permission-list',
                'display_name' => 'List of Permissions',
                'description' => 'See only List of Permissions'
            ],
            [
                'name' => 'permission-create',
                'display_name' => 'Create Permission',
                'description' => 'To Create only Permission'
            ],
            [
                'name' => 'permission-edit',
                'display_name' => 'Edit Permission',
                'description' => 'To Edit Permission'
            ],
            [
                'name' => 'permission-delete',
                'display_name' => 'Delete Permission',
                'description' => 'To Delete Permission'
            ],
            [
                'name' => 'settings',
                'display_name' => 'Settings',
                'description' => 'Settings'
            ],[
                'name' => 'create-channel',
                'display_name' => 'Create channel',
                'description' => 'Create channel'
            ],[
                'name' => 'subscribed-users',
                'display_name' => 'Subscribed Users',
                'description' => 'Subscribed Users'
            ],[
                'name' => 'chat',
                'display_name' => 'Chat',
                'description' => 'Chat with channel users'
            ],[
                'name' => 'upload-content',
                'display_name' => 'Upload Content to channel',
                'description' => 'To be able to upload content to channel'
            ],[
                'name' => 'create-ad',
                'display_name' => 'Create Advertisement',
                'description' => 'To be able to create ad and see list of ads'
            ],
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }

        $role = DB::table('roles')->insert([
            'name' => 'super-admin',
            'display_name' => 'Super Admin',
            'description' => 'Super Admin who has control over the whole Bushfire admin panel'
        ]);

        $all_permissions = Permission::get();
        foreach($all_permissions as $permission){
            $role->attachPermission($permission->id);
        }

        /*$role = DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1
        ]);*/
    }
}
