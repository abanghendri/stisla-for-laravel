<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

         // create permissions
        Permission::create(['name' => 'users']); // for parent
        Permission::create(['name' => 'users.create','display'  => 'Create User']);
        Permission::create(['name' => 'users.edit','display'  => 'Update User']);
        Permission::create(['name' => 'users.delete','display'  => 'Delete User']);
        
        Permission::create(['name' => 'roles']); // for parent
        Permission::create(['name' => 'roles.create', 'display'  => 'Create Roles']);
        Permission::create(['name' => 'roles.edit', 'display'  => 'Update Roles']);
        Permission::create(['name' => 'roles.delete', 'display'  => 'Delete Roles']);


        $role = Role::create(['name' => 'Super Admin']);

        // asign superadmin to all permission
        $role->givePermissionTo(Permission::all());
        
        $user = \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $user->assignRole($role);
        Role::create(['name' => 'Member']);
    }
}
