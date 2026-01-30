<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super_admin',
                'description' => 'Full system access and control'
            ],
            [
                'name' => 'Director',
                'slug' => 'director',
                'description' => 'Company director - manages entire company operations'
            ],
            [
                'name' => 'Agency Manager',
                'slug' => 'agency_manager',
                'description' => 'Manages specific agency operations'
            ],
            [
                'name' => 'Counter Clerk',
                'slug' => 'counter_clerk',
                'description' => 'Handles reservations and ticket sales'
            ],
            [
                'name' => 'Accountant',
                'slug' => 'accountant',
                'description' => 'Manages financial transactions and reports'
            ],
            [
                'name' => 'Driver',
                'slug' => 'driver',
                'description' => 'Drives vehicles and manages trips'
            ],
            [
                'name' => 'Customer',
                'slug' => 'customer',
                'description' => 'Regular customer/passenger'
            ],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(['slug' => $roleData['slug']], $roleData);
        }

        // Create Permissions
        $permissions = [
            // Company Management
            ['name' => 'view_companies', 'module' => 'company', 'action' => 'view', 'description' => 'View companies list'],
            ['name' => 'create_companies', 'module' => 'company', 'action' => 'create', 'description' => 'Create companies'],
            ['name' => 'edit_companies', 'module' => 'company', 'action' => 'edit', 'description' => 'Edit companies'],
            ['name' => 'delete_companies', 'module' => 'company', 'action' => 'delete', 'description' => 'Delete companies'],
            
            // Agency Management
            ['name' => 'view_agencies', 'module' => 'agency', 'action' => 'view', 'description' => 'View agencies list'],
            ['name' => 'create_agencies', 'module' => 'agency', 'action' => 'create', 'description' => 'Create agencies'],
            ['name' => 'edit_agencies', 'module' => 'agency', 'action' => 'edit', 'description' => 'Edit agencies'],
            ['name' => 'delete_agencies', 'module' => 'agency', 'action' => 'delete', 'description' => 'Delete agencies'],
            
            // User Management
            ['name' => 'view_users', 'module' => 'user', 'action' => 'view', 'description' => 'View users list'],
            ['name' => 'create_users', 'module' => 'user', 'action' => 'create', 'description' => 'Create users'],
            ['name' => 'edit_users', 'module' => 'user', 'action' => 'edit', 'description' => 'Edit users'],
            ['name' => 'delete_users', 'module' => 'user', 'action' => 'delete', 'description' => 'Delete users'],
            
            // Reservation Management
            ['name' => 'view_reservations', 'module' => 'reservation', 'action' => 'view', 'description' => 'View reservations'],
            ['name' => 'create_reservations', 'module' => 'reservation', 'action' => 'create', 'description' => 'Create reservations'],
            ['name' => 'edit_reservations', 'module' => 'reservation', 'action' => 'edit', 'description' => 'Edit reservations'],
            ['name' => 'cancel_reservations', 'module' => 'reservation', 'action' => 'cancel', 'description' => 'Cancel reservations'],
            
            // Trip Management
            ['name' => 'view_trips', 'module' => 'trip', 'action' => 'view', 'description' => 'View trips'],
            ['name' => 'create_trips', 'module' => 'trip', 'action' => 'create', 'description' => 'Create trips'],
            ['name' => 'edit_trips', 'module' => 'trip', 'action' => 'edit', 'description' => 'Edit trips'],
            ['name' => 'cancel_trips', 'module' => 'trip', 'action' => 'cancel', 'description' => 'Cancel trips'],
            
            // Financial
            ['name' => 'view_transactions', 'module' => 'finance', 'action' => 'view', 'description' => 'View transactions'],
            ['name' => 'create_transactions', 'module' => 'finance', 'action' => 'create', 'description' => 'Create transactions'],
            ['name' => 'view_reports', 'module' => 'finance', 'action' => 'view_reports', 'description' => 'View financial reports'],
            ['name' => 'manage_cash_registers', 'module' => 'finance', 'action' => 'manage_registers', 'description' => 'Manage cash registers'],
            
            // Vehicle Management
            ['name' => 'view_vehicles', 'module' => 'vehicle', 'action' => 'view', 'description' => 'View vehicles'],
            ['name' => 'create_vehicles', 'module' => 'vehicle', 'action' => 'create', 'description' => 'Create vehicles'],
            ['name' => 'edit_vehicles', 'module' => 'vehicle', 'action' => 'edit', 'description' => 'Edit vehicles'],
            ['name' => 'delete_vehicles', 'module' => 'vehicle', 'action' => 'delete', 'description' => 'Delete vehicles'],
            
            // Employee Management
            ['name' => 'view_employees', 'module' => 'employee', 'action' => 'view', 'description' => 'View employees'],
            ['name' => 'create_employees', 'module' => 'employee', 'action' => 'create', 'description' => 'Create employees'],
            ['name' => 'edit_employees', 'module' => 'employee', 'action' => 'edit', 'description' => 'Edit employees'],
            ['name' => 'delete_employees', 'module' => 'employee', 'action' => 'delete', 'description' => 'Delete employees'],
        ];

        foreach ($permissions as $permissionData) {
            Permission::firstOrCreate(['name' => $permissionData['name']], $permissionData);
        }

        // Assign permissions to roles
        $superAdmin = Role::where('slug', 'super_admin')->first();
        if ($superAdmin) {
            $superAdmin->permissions()->sync(Permission::all());
        }

        $director = Role::where('slug', 'director')->first();
        if ($director) {
            $director->permissions()->sync(Permission::whereIn('module', ['company', 'agency', 'user', 'reservation', 'trip', 'vehicle', 'finance', 'employee'])->pluck('id'));
        }

        $agencyManager = Role::where('slug', 'agency_manager')->first();
        if ($agencyManager) {
            $agencyManager->permissions()->sync(Permission::whereIn('module', ['reservation', 'trip', 'user', 'vehicle', 'finance', 'employee'])->where('action', '!=', 'delete')->pluck('id'));
        }

        $counterClerk = Role::where('slug', 'counter_clerk')->first();
        if ($counterClerk) {
            $counterClerk->permissions()->sync(Permission::whereIn('name', ['view_reservations', 'create_reservations', 'edit_reservations', 'view_trips'])->pluck('id'));
        }

        $accountant = Role::where('slug', 'accountant')->first();
        if ($accountant) {
            $accountant->permissions()->sync(Permission::where('module', 'finance')->pluck('id'));
        }

        $driver = Role::where('slug', 'driver')->first();
        if ($driver) {
            $driver->permissions()->sync(Permission::whereIn('name', ['view_trips'])->pluck('id'));
        }

        $this->command->info('✅ Roles and permissions created successfully!');
    }
}