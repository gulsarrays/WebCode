<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'administrator']);
        $role->givePermissionTo('users_manage');
        $role->givePermissionTo('role-list');
        $role->givePermissionTo('role-create');
        $role->givePermissionTo('role-edit');
        $role->givePermissionTo('role-delete');
        $role->givePermissionTo('product-list');
        $role->givePermissionTo('product-create');
        $role->givePermissionTo('product-edit');
        $role->givePermissionTo('product-delete');
        
        $role = Role::create(['name' => 'web_app_tenant']);
        $role->givePermissionTo('product-list');
        $role->givePermissionTo('product-create');
        $role->givePermissionTo('product-edit');
        $role->givePermissionTo('product-delete');
    }
}
