<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $roles = [
            [
                'name' => 'super_admin',
                'description' => 'Full system access and configuration',
            ],
            [
                'name' => 'director',
                'description' => 'Overview all agencies and reports',
            ],
            [
                'name' => 'agency_manager',
                'description' => 'Complete management of assigned agency',
            ],
            [
                'name' => 'counter_clerk',
                'description' => 'Ticket sales and reservation management',
            ],
            [
                'name' => 'accountant',
                'description' => 'Financial management and reporting',
            ],
            [
                'name' => 'driver',
                'description' => 'Driver portal and trip management',
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'name' => $role['name'],
                'description' => $role['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create Permissions by Module
        $permissions = [
            // Core Module
            ['name' => 'manage_users', 'module' => 'core', 'action' => 'manage', 'description' => 'Create, edit, delete users'],
            ['name' => 'manage_roles', 'module' => 'core', 'action' => 'manage', 'description' => 'Manage roles and permissions'],
            ['name' => 'view_system_logs', 'module' => 'core', 'action' => 'view', 'description' => 'View system logs'],
            ['name' => 'system_configuration', 'module' => 'core', 'action' => 'configure', 'description' => 'Configure system settings'],

            // Agencies Module
            ['name' => 'manage_companies', 'module' => 'agencies', 'action' => 'manage', 'description' => 'Manage transport companies'],
            ['name' => 'manage_agencies', 'module' => 'agencies', 'action' => 'manage', 'description' => 'Manage agencies/bus stations'],
            ['name' => 'view_agencies', 'module' => 'agencies', 'action' => 'view', 'description' => 'View agency information'],

            // Transport Module
            ['name' => 'manage_routes', 'module' => 'transport', 'action' => 'manage', 'description' => 'Manage routes and connections'],
            ['name' => 'manage_schedules', 'module' => 'transport', 'action' => 'manage', 'description' => 'Manage departure schedules'],
            ['name' => 'manage_fares', 'module' => 'transport', 'action' => 'manage', 'description' => 'Manage pricing and fares'],
            ['name' => 'view_routes', 'module' => 'transport', 'action' => 'view', 'description' => 'View routes and schedules'],

            // Reservations Module
            ['name' => 'create_reservations', 'module' => 'reservations', 'action' => 'create', 'description' => 'Create new reservations'],
            ['name' => 'manage_reservations', 'module' => 'reservations', 'action' => 'manage', 'description' => 'Full reservation management'],
            ['name' => 'view_reservations', 'module' => 'reservations', 'action' => 'view', 'description' => 'View reservations'],
            ['name' => 'cancel_reservations', 'module' => 'reservations', 'action' => 'cancel', 'description' => 'Cancel and refund reservations'],
            ['name' => 'validate_tickets', 'module' => 'reservations', 'action' => 'validate', 'description' => 'Validate boarding tickets'],

            // Fleet Module
            ['name' => 'manage_vehicles', 'module' => 'fleet', 'action' => 'manage', 'description' => 'Manage vehicle fleet'],
            ['name' => 'manage_maintenance', 'module' => 'fleet', 'action' => 'manage', 'description' => 'Manage vehicle maintenance'],
            ['name' => 'view_fleet', 'module' => 'fleet', 'action' => 'view', 'description' => 'View fleet information'],

            // Personnel Module
            ['name' => 'manage_employees', 'module' => 'personnel', 'action' => 'manage', 'description' => 'Manage employees'],
            ['name' => 'manage_drivers', 'module' => 'personnel', 'action' => 'manage', 'description' => 'Manage drivers'],
            ['name' => 'view_employees', 'module' => 'personnel', 'action' => 'view', 'description' => 'View employee information'],

            // Financial Module
            ['name' => 'manage_cash_registers', 'module' => 'financial', 'action' => 'manage', 'description' => 'Open/close cash registers'],
            ['name' => 'process_payments', 'module' => 'financial', 'action' => 'process', 'description' => 'Process payments'],
            ['name' => 'manage_expenses', 'module' => 'financial', 'action' => 'manage', 'description' => 'Record and manage expenses'],
            ['name' => 'view_financial_reports', 'module' => 'financial', 'action' => 'view', 'description' => 'View financial reports'],
            ['name' => 'validate_transactions', 'module' => 'financial', 'action' => 'validate', 'description' => 'Validate financial transactions'],

            // Reporting Module
            ['name' => 'view_all_reports', 'module' => 'reporting', 'action' => 'view', 'description' => 'View all system reports'],
            ['name' => 'view_agency_reports', 'module' => 'reporting', 'action' => 'view', 'description' => 'View agency-specific reports'],
            ['name' => 'export_reports', 'module' => 'reporting', 'action' => 'export', 'description' => 'Export reports'],

            // Notifications Module
            ['name' => 'send_notifications', 'module' => 'notifications', 'action' => 'send', 'description' => 'Send customer notifications'],
            ['name' => 'configure_notifications', 'module' => 'notifications', 'action' => 'configure', 'description' => 'Configure notification settings'],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert([
                'name' => $permission['name'],
                'module' => $permission['module'],
                'action' => $permission['action'],
                'description' => $permission['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Assign Permissions to Roles
        $this->assignPermissionsToRoles();

        // Create default Super Admin user
        $this->createDefaultUsers();
    }

    /**
     * Assign permissions to each role
     */
    private function assignPermissionsToRoles(): void
    {
        $rolePermissions = [
            'super_admin' => 'all', // Gets all permissions
            
            'director' => [
                'view_agencies', 'view_routes', 'manage_fares', 'view_reservations',
                'view_fleet', 'view_employees', 'view_all_reports', 'export_reports',
                'view_financial_reports', 'validate_transactions',
            ],
            
            'agency_manager' => [
                'view_agencies', 'view_routes', 'manage_schedules', 'create_reservations',
                'manage_reservations', 'view_reservations', 'cancel_reservations',
                'validate_tickets', 'view_fleet', 'manage_employees', 'manage_drivers',
                'manage_cash_registers', 'process_payments', 'manage_expenses',
                'view_agency_reports', 'export_reports', 'send_notifications',
            ],
            
            'counter_clerk' => [
                'view_routes', 'create_reservations', 'view_reservations',
                'validate_tickets', 'manage_cash_registers', 'process_payments',
            ],
            
            'accountant' => [
                'view_reservations', 'manage_cash_registers', 'process_payments',
                'manage_expenses', 'view_financial_reports', 'validate_transactions',
                'view_agency_reports', 'export_reports',
            ],
            
            'driver' => [
                'view_routes', 'view_reservations', 'validate_tickets',
            ],
        ];

        foreach ($rolePermissions as $roleName => $permissions) {
            $role = DB::table('roles')->where('name', $roleName)->first();
            
            if ($permissions === 'all') {
                // Super admin gets all permissions
                $allPermissions = DB::table('permissions')->pluck('id');
                foreach ($allPermissions as $permissionId) {
                    DB::table('role_permission')->insert([
                        'role_id' => $role->id,
                        'permission_id' => $permissionId,
                    ]);
                }
            } else {
                foreach ($permissions as $permissionName) {
                    $permission = DB::table('permissions')->where('name', $permissionName)->first();
                    if ($permission) {
                        DB::table('role_permission')->insert([
                            'role_id' => $role->id,
                            'permission_id' => $permission->id,
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Create default system users
     */
    private function createDefaultUsers(): void
    {
        $superAdminRole = DB::table('roles')->where('name', 'super_admin')->first();

        DB::table('users')->insert([
            'first_name' => 'System',
            'last_name' => 'Administrator',
            'email' => 'admin@roadtransport.cm',
            'phone' => '677000000',
            'password' => Hash::make('Admin@123'),
            'role_id' => $superAdminRole->id,
            'status' => 'active',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}