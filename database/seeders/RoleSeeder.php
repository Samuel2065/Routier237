<?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class RoleSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            $roles = [
                [
                    'name' => 'Super Admin',
                    'slug' => 'super_admin',
                    'description' => 'Full system access and management',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Director',
                    'slug' => 'director',
                    'description' => 'Overview all agencies and reports',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Agency Manager',
                    'slug' => 'agency_manager',
                    'description' => 'Complete management of their agency',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Counter Clerk',
                    'slug' => 'counter_clerk',
                    'description' => 'Ticket sales and reservation management',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Accountant',
                    'slug' => 'accountant',
                    'description' => 'Financial management and reports',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Driver',
                    'slug' => 'driver',
                    'description' => 'Driver operations and schedule',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Customer',
                    'slug' => 'customer',
                    'description' => 'Regular customer/passenger',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            DB::table('roles')->insert($roles);
        }
    }