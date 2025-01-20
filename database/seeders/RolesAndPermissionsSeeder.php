<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'manage category']);
        Permission::create(['name' => 'manage tag']);
        Permission::create(['name' => 'add user']);
        Permission::create(['name' => 'block user']);
        Permission::create(['name' => 'add comment']);
        Permission::create(['name' => 'delete comment']);
        Permission::create(['name' => 'edit comment']);
        Permission::create(['name' => 'add post']);
        Permission::create(['name' => 'edit post']);
        Permission::create(['name' => 'delete post']);
        Permission::create(['name' => 'show post']);


        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(['manage category' , 'manage tag', 'add user', 'block user','add comment', 'edit comment', 'delete comment','add post', 'delete post', 'edit post','show post']);
        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo(['add comment', 'edit comment', 'delete comment','add post', 'delete post', 'edit post','show post']);
    }
}
