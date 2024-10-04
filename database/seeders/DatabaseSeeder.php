<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Tạo vai trò nếu chưa tồn tại
        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }

        if (!Role::where('name', 'member')->exists()) {
            Role::create(['name' => 'member']);
        }

        // Tạo quyền nếu chưa tồn tại
        if (!Permission::where('name', 'manage users')->exists()) {
            Permission::create(['name' => 'manage users']);
        }

        if (!Permission::where('name', 'view content')->exists()) {
            Permission::create(['name' => 'view content']);
        }

        // Gán quyền cho vai trò
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo('manage users');
        $adminRole->givePermissionTo('view content');

        $memberRole = Role::findByName('member');
        $memberRole->givePermissionTo('view content');
    }
}
