<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'users.view', 'module' => 'users', 'action' => 'view', 'description' => 'View users'],
            ['name' => 'users.create', 'module' => 'users', 'action' => 'create', 'description' => 'Create users'],
            ['name' => 'users.edit', 'module' => 'users', 'action' => 'edit', 'description' => 'Edit users'],
            ['name' => 'users.delete', 'module' => 'users', 'action' => 'delete', 'description' => 'Delete users'],

            ['name' => 'agencies.view', 'module' => 'agencies', 'action' => 'view', 'description' => 'View agencies'],
            ['name' => 'agencies.create', 'module' => 'agencies', 'action' => 'create', 'description' => 'Create agencies'],
            ['name' => 'agencies.edit', 'module' => 'agencies', 'action' => 'edit', 'description' => 'Edit agencies'],
            ['name' => 'agencies.delete', 'module' => 'agencies', 'action' => 'delete', 'description' => 'Delete agencies'],

            ['name' => 'reservations.view', 'module' => 'reservations', 'action' => 'view', 'description' => 'View reservations'],
            ['name' => 'reservations.create', 'module' => 'reservations', 'action' => 'create', 'description' => 'Create reservations'],
            ['name' => 'reservations.edit', 'module' => 'reservations', 'action' => 'edit', 'description' => 'Edit reservations'],
            ['name' => 'reservations.cancel', 'module' => 'reservations', 'action' => 'cancel', 'description' => 'Cancel reservations'],

            ['name' => 'fleet.view', 'module' => 'fleet', 'action' => 'view', 'description' => 'View fleet'],
            ['name' => 'fleet.create', 'module' => 'fleet', 'action' => 'create', 'description' => 'Create fleet'],
            ['name' => 'fleet.edit', 'module' => 'fleet', 'action' => 'edit', 'description' => 'Edit fleet'],
            ['name' => 'fleet.delete', 'module' => 'fleet', 'action' => 'delete', 'description' => 'Delete fleet'],

            ['name' => 'financial.view', 'module' => 'financial', 'action' => 'view', 'description' => 'View financial data'],
            ['name' => 'financial.manage', 'module' => 'financial', 'action' => 'manage', 'description' => 'Manage finances'],
            ['name' => 'cash_register.open', 'module' => 'financial', 'action' => 'open', 'description' => 'Open cash register'],
            ['name' => 'cash_register.close', 'module' => 'financial', 'action' => 'close', 'description' => 'Close cash register'],

            ['name' => 'reports.view', 'module' => 'reports', 'action' => 'view', 'description' => 'View reports'],
            ['name' => 'reports.export', 'module' => 'reports', 'action' => 'export', 'description' => 'Export reports'],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $permission['name']], // UNIQUE
                array_merge($permission, [
                    'updated_at' => now(),
                    'created_at' => now(),
                ])
            );
        }

        $this->assignPermissionsToRoles();
    }

    private function assignPermissionsToRoles(): void
    {
        // SUPER ADMIN
        if ($superAdmin = DB::table('roles')->where('slug', 'super_admin')->first()) {
            $permissions = DB::table('permissions')->pluck('id');
            foreach ($permissions as $permissionId) {
                DB::table('role_permission')->insertOrIgnore([
                    'role_id' => $superAdmin->id,
                    'permission_id' => $permissionId,
                ]);
            }
        }

        // COUNTER CLERK
        if ($clerk = DB::table('roles')->where('slug', 'counter_clerk')->first()) {
            $permissions = DB::table('permissions')
                ->whereIn('name', [
                    'reservations.view',
                    'reservations.create',
                    'cash_register.open',
                    'cash_register.close',
                ])
                ->pluck('id');

            foreach ($permissions as $permissionId) {
                DB::table('role_permission')->insertOrIgnore([
                    'role_id' => $clerk->id,
                    'permission_id' => $permissionId,
                ]);
            }
        }

        // CUSTOMER
        if ($customer = DB::table('roles')->where('slug', 'customer')->first()) {
            $permissions = DB::table('permissions')
                ->whereIn('name', [
                    'reservations.view',
                    'reservations.create',
                    'reservations.cancel',
                ])
                ->pluck('id');

            foreach ($permissions as $permissionId) {
                DB::table('role_permission')->insertOrIgnore([
                    'role_id' => $customer->id,
                    'permission_id' => $permissionId,
                ]);
            }
        }
    }
}
