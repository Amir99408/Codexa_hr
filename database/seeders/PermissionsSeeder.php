<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage-employees',
            'manage-departments',
            'manage-attendance',
            'manage-leaves',
            'manage-payroll',
            'manage-advances',
            'manage-expenses',
            'manage-warnings',
            'manage-performance',
            'manage-recruitment',
            'manage-shifts',
            'manage-holidays',
            'manage-settings',
            'view-reports',
            'view-audit-log',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // admin — everything
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions($permissions);

        // hr_manager — people operations
        $hr = Role::firstOrCreate(['name' => 'hr_manager']);
        $hr->syncPermissions([
            'manage-employees',
            'manage-departments',
            'manage-attendance',
            'manage-leaves',
            'manage-warnings',
            'manage-performance',
            'manage-recruitment',
            'manage-shifts',
            'manage-holidays',
            'view-reports',
        ]);

        // finance — financial operations
        $finance = Role::firstOrCreate(['name' => 'finance']);
        $finance->syncPermissions([
            'manage-payroll',
            'manage-advances',
            'manage-expenses',
            'view-reports',
        ]);

        // dept_manager — limited view + leave approval for own department
        $dept = Role::firstOrCreate(['name' => 'dept_manager']);
        $dept->syncPermissions([
            'manage-attendance',
            'manage-leaves',
            'view-reports',
        ]);

        // employee role — no admin permissions
        Role::firstOrCreate(['name' => 'employee']);

        $this->command->info('Roles and permissions seeded.');
    }
}
