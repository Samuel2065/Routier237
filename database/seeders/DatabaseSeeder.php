<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Company;
use App\Models\City;
use App\Models\Client;
use App\Models\Agency;
use App\Models\Route;
use App\Models\Trip;
use App\Models\TripPrice;
use App\Models\Vehicle;
use App\Models\Seat;
use App\Models\Employee;
use App\Models\Driver;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // First, run the role and permission seeder
        $this->call(RoleAndPermissionSeeder::class);

        // Get roles
        $superAdminRole = Role::where('slug', 'super_admin')->first();
        $directorRole = Role::where('slug', 'director')->first();
        $agencyManagerRole = Role::where('slug', 'agency_manager')->first();

        // Create Super Admin (idempotent)
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'full_name' => 'Super Admin',
                'phone' => '677000001',
                'password' => bcrypt('password'),
                'user_type' => 'staff',
                'role_id' => $superAdminRole->id,
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // Create Cities with realistic data
        $citiesData = [
            ['name' => 'Yaoundé', 'slug' => 'yaounde', 'region' => 'Centre', 'postal_code' => '1000'],
            ['name' => 'Douala', 'slug' => 'douala', 'region' => 'Littoral', 'postal_code' => '2000'],
            ['name' => 'Bafoussam', 'slug' => 'bafoussam', 'region' => 'Ouest', 'postal_code' => '3000'],
            ['name' => 'Garoua', 'slug' => 'garoua', 'region' => 'Nord', 'postal_code' => '4000'],
            ['name' => 'Maroua', 'slug' => 'maroua', 'region' => 'Extrême-Nord', 'postal_code' => '5000'],
            ['name' => 'Bamenda', 'slug' => 'bamenda', 'region' => 'Nord-Ouest', 'postal_code' => '6000'],
            ['name' => 'Buea', 'slug' => 'buea', 'region' => 'Sud-Ouest', 'postal_code' => '7000'],
            ['name' => 'Bertoua', 'slug' => 'bertoua', 'region' => 'Est', 'postal_code' => '8000'],
            ['name' => 'Ngaoundéré', 'slug' => 'ngaoundere', 'region' => 'Adamaoua', 'postal_code' => '9000'],
            ['name' => 'Ebolowa', 'slug' => 'ebolowa', 'region' => 'Sud', 'postal_code' => '10000'],
        ];

        $cities = City::all()->keyBy('name');
        if ($cities->isEmpty()) {
            foreach ($citiesData as $cityData) {
                $cities[$cityData['name']] = City::create($cityData);
            }
            $cities = City::all()->keyBy('name');
        }

        // Create Companies with Directors and descriptions
        $companiesData = [
            [
                'name' => 'Centrale Voyage', 
                'acronym' => 'CV', 
                'email' => 'centrale@gmail.com',
                'description' => 'Centrale Voyage is a leading transport agency in Cameroon, providing quality services since 2015. We serve major cities across the country with a modern fleet and qualified staff.'
            ],
            [
                'name' => 'Express Voyage', 
                'acronym' => 'EV', 
                'email' => 'express@gmail.com',
                'description' => 'Express Voyage offers fast and reliable inter-city transport services with comfortable buses and professional drivers. Your safety and comfort are our priority.'
            ],
            [
                'name' => 'Overline Voyage', 
                'acronym' => 'OV', 
                'email' => 'overline@gmail.com',
                'description' => 'Overline Voyage is a premium transport company serving Cameroon since 2010. We pride ourselves on punctuality, safety, and customer satisfaction.'
            ],
            [
                'name' => 'Royal Express', 
                'acronym' => 'RE', 
                'email' => 'royal@gmail.com',
                'description' => 'Royal Express provides luxury transport services across Cameroon with VIP buses, air conditioning, and entertainment systems for your comfort.'
            ],
            [
                'name' => 'Touristique Express', 
                'acronym' => 'TE', 
                'email' => 'touristique@gmail.com',
                'description' => 'Touristique Express specializes in long-distance travel with modern amenities. Experience comfort and reliability on every journey with us.'
            ],
        ];

        $companies = Company::all();
        if ($companies->isEmpty()) {
            $companies = [];
            foreach ($companiesData as $index => $companyData) {
                // Create director
                $director = User::firstOrCreate(
                    ['email' => 'director' . ($index + 1) . '@gmail.com'],
                    [
                        'full_name' => 'Director ' . $companyData['acronym'],
                        'phone' => '67700000' . ($index + 2),
                        'password' => bcrypt('password'),
                        'user_type' => 'staff',
                        'role_id' => $directorRole->id,
                        'status' => 'active',
                        'email_verified_at' => now(),
                    ]
                );

                $companies[] = Company::firstOrCreate(
                    ['email' => $companyData['email']],
                    [
                        'name' => $companyData['name'],
                        'acronym' => $companyData['acronym'],
                        'slug' => Str::slug($companyData['name']),
                        'phone' => '67700' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                        'taxpayer_number' => 'TPN' . str_pad($index + 1, 6, '0', STR_PAD_LEFT),
                        'headquarters_address' => 'Quartier Central, ' . $citiesData[$index]['name'],
                        'director_id' => $director->id,
                        'description' => $companyData['description'],
                        'status' => 'active',
                        'approval_status' => 'approved',
                        'approved_by' => $superAdmin->id,
                        'approved_at' => now(),
                    ]
                );
            }
        }

        // Create Agencies across different cities
        $agenciesData = [
            // Yaoundé agencies
            ['company' => 0, 'city' => 'Yaoundé', 'name' => 'Centrale Voyage Yaoundé Centre', 'district' => 'Centre Ville'],
            ['company' => 0, 'city' => 'Yaoundé', 'name' => 'Centrale Voyage Mvan', 'district' => 'Mvan'],
            ['company' => 0, 'city' => 'Yaoundé', 'name' => 'Centrale Voyage Ngousso', 'district' => 'Ngousso'],
            ['company' => 1, 'city' => 'Yaoundé', 'name' => 'Express Voyage Yaoundé', 'district' => 'Centre Ville'],
            ['company' => 2, 'city' => 'Yaoundé', 'name' => 'Overline Voyage Yaoundé', 'district' => 'Messa'],
            
            // Douala agencies
            ['company' => 0, 'city' => 'Douala', 'name' => 'Centrale Voyage Douala Akwa', 'district' => 'Akwa'],
            ['company' => 0, 'city' => 'Douala', 'name' => 'Centrale Voyage Bonabéri', 'district' => 'Bonabéri'],
            ['company' => 1, 'city' => 'Douala', 'name' => 'Express Voyage Douala', 'district' => 'Bonanjo'],
            ['company' => 2, 'city' => 'Douala', 'name' => 'Overline Voyage Douala', 'district' => 'Akwa'],
            ['company' => 3, 'city' => 'Douala', 'name' => 'Royal Express Douala', 'district' => 'Bali'],
            
            // Bafoussam agencies
            ['company' => 0, 'city' => 'Bafoussam', 'name' => 'Centrale Voyage Bafoussam', 'district' => 'Centre'],
            ['company' => 1, 'city' => 'Bafoussam', 'name' => 'Express Voyage Bafoussam', 'district' => 'Tamdja'],
            ['company' => 4, 'city' => 'Bafoussam', 'name' => 'Touristique Express Bafoussam', 'district' => 'Centre'],
            
            // Garoua agencies
            ['company' => 0, 'city' => 'Garoua', 'name' => 'Centrale Voyage Garoua', 'district' => 'Centre'],
            ['company' => 1, 'city' => 'Garoua', 'name' => 'Express Voyage Garoua', 'district' => 'Plateau'],
            
            // Bertoua agencies
            ['company' => 0, 'city' => 'Bertoua', 'name' => 'Centrale Voyage Bertoua', 'district' => 'Centre'],
            ['company' => 2, 'city' => 'Bertoua', 'name' => 'Overline Voyage Bertoua', 'district' => 'Nkolbisson'],
            
            // Bamenda agencies
            ['company' => 1, 'city' => 'Bamenda', 'name' => 'Express Voyage Bamenda', 'district' => 'Commercial Avenue'],
            ['company' => 3, 'city' => 'Bamenda', 'name' => 'Royal Express Bamenda', 'district' => 'Sonac'],
            
            // Buea agencies
            ['company' => 2, 'city' => 'Buea', 'name' => 'Overline Voyage Buea', 'district' => 'Molyko'],
            ['company' => 3, 'city' => 'Buea', 'name' => 'Royal Express Buea', 'district' => 'Great Soppo'],
            
            // Maroua agencies
            ['company' => 0, 'city' => 'Maroua', 'name' => 'Centrale Voyage Maroua', 'district' => 'Centre'],
            ['company' => 4, 'city' => 'Maroua', 'name' => 'Touristique Express Maroua', 'district' => 'Domayo'],
        ];

        $agencies = Agency::all();
        if ($agencies->isEmpty() && !$companies->isEmpty()) {
            $agencies = [];
            $companiesCollection = collect($companies)->values();

            foreach ($agenciesData as $index => $agencyData) {
                // Create manager
                $manager = User::firstOrCreate(
                    ['email' => 'manager' . ($index + 1) . '@gmail.com'],
                    [
                        'full_name' => 'Manager ' . ($index + 1),
                        'phone' => '67800000' . str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                        'password' => bcrypt('password'),
                        'user_type' => 'staff',
                        'role_id' => $agencyManagerRole->id,
                        'status' => 'active',
                        'email_verified_at' => now(),
                    ]
                );

                $company = $companiesCollection[$agencyData['company']] ?? $companiesCollection->first();

                $agencies[] = Agency::firstOrCreate(
                    ['agency_code' => 'AG' . str_pad($index + 1, 4, '0', STR_PAD_LEFT)],
                    [
                        'company_id' => $company->id,
                        'city_id' => $cities[$agencyData['city']]->id,
                        'manager_id' => $manager->id,
                        'name' => $agencyData['name'],
                        'district' => $agencyData['district'],
                        'full_address' => $agencyData['district'] . ', ' . $agencyData['city'],
                        'slug' => Str::slug($agencyData['name']),
                        'rating' => 4.5,
                        'phone' => '67800' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                        'email' => Str::slug($agencyData['name']) . '@gmail.com',
                        'type' => $index % 3 == 0 ? 'main' : 'secondary',
                        'status' => 'active',
                        'approval_status' => 'approved',
                    ]
                );
            }
        }

        // Create Routes between major cities
        $routesData = [
            // From Yaoundé
            ['from' => 'Yaoundé', 'to' => 'Douala', 'distance' => 240, 'duration' => 210, 'price' => 2500],
            ['from' => 'Yaoundé', 'to' => 'Bafoussam', 'distance' => 280, 'duration' => 300, 'price' => 3500],
            ['from' => 'Yaoundé', 'to' => 'Garoua', 'distance' => 850, 'duration' => 780, 'price' => 8500],
            ['from' => 'Yaoundé', 'to' => 'Bertoua', 'distance' => 350, 'duration' => 360, 'price' => 4500],
            ['from' => 'Yaoundé', 'to' => 'Ebolowa', 'distance' => 170, 'duration' => 180, 'price' => 2000],
            ['from' => 'Yaoundé', 'to' => 'Bamenda', 'distance' => 370, 'duration' => 400, 'price' => 5000],
            
            // From Douala
            ['from' => 'Douala', 'to' => 'Yaoundé', 'distance' => 240, 'duration' => 210, 'price' => 2500],
            ['from' => 'Douala', 'to' => 'Bafoussam', 'distance' => 290, 'duration' => 270, 'price' => 3500],
            ['from' => 'Douala', 'to' => 'Buea', 'distance' => 75, 'duration' => 90, 'price' => 1500],
            ['from' => 'Douala', 'to' => 'Bamenda', 'distance' => 350, 'duration' => 360, 'price' => 4500],
            
            // From Bafoussam
            ['from' => 'Bafoussam', 'to' => 'Yaoundé', 'distance' => 280, 'duration' => 300, 'price' => 3500],
            ['from' => 'Bafoussam', 'to' => 'Douala', 'distance' => 290, 'duration' => 270, 'price' => 3500],
            ['from' => 'Bafoussam', 'to' => 'Bamenda', 'distance' => 75, 'duration' => 90, 'price' => 1500],
            
            // From Bertoua
            ['from' => 'Bertoua', 'to' => 'Yaoundé', 'distance' => 350, 'duration' => 360, 'price' => 4500],
            ['from' => 'Bertoua', 'to' => 'Douala', 'distance' => 550, 'duration' => 600, 'price' => 6500],
            
            // From Garoua
            ['from' => 'Garoua', 'to' => 'Yaoundé', 'distance' => 850, 'duration' => 780, 'price' => 8500],
            ['from' => 'Garoua', 'to' => 'Maroua', 'distance' => 280, 'duration' => 240, 'price' => 3500],
            ['from' => 'Garoua', 'to' => 'Ngaoundéré', 'distance' => 280, 'duration' => 240, 'price' => 3500],
            
            // From Bamenda
            ['from' => 'Bamenda', 'to' => 'Douala', 'distance' => 350, 'duration' => 360, 'price' => 4500],
            ['from' => 'Bamenda', 'to' => 'Yaoundé', 'distance' => 370, 'duration' => 400, 'price' => 5000],
            ['from' => 'Bamenda', 'to' => 'Bafoussam', 'distance' => 75, 'duration' => 90, 'price' => 1500],
            
            // From Buea
            ['from' => 'Buea', 'to' => 'Douala', 'distance' => 75, 'duration' => 90, 'price' => 1500],
            ['from' => 'Buea', 'to' => 'Yaoundé', 'distance' => 310, 'duration' => 300, 'price' => 4000],
        ];

        $routes = Route::all();
        if ($routes->isEmpty()) {
            $routes = [];
            foreach ($routesData as $routeData) {
                $routes[] = Route::firstOrCreate(
                    [
                        'from_city_id' => $cities[$routeData['from']]->id,
                        'to_city_id' => $cities[$routeData['to']]->id,
                    ],
                    [
                        'distance_km' => $routeData['distance'],
                        'estimated_duration_min' => $routeData['duration'],
                        'price' => $routeData['price'],
                        'status' => 'active',
                    ]
                );
            }
        }

        // Create Vehicles for agencies
        $vehicleTypes = ['bus', 'coaster', 'minibus'];
        $seatCounts = [70, 30, 15];
        
        if (Vehicle::count() === 0 && !empty($agencies)) {
            $agenciesCollection = collect($agencies)->values();
            // Create 2-3 vehicles per agency
            foreach ($agenciesCollection as $index => $agency) {
                $vehicleCount = rand(2, 3);
                for ($i = 0; $i < $vehicleCount; $i++) {
                    $typeIndex = $i % 3;
                    $vehicle = Vehicle::create([
                        'company_id' => $agency->company_id,
                        'plate_number' => 'LT-' . str_pad($index, 3, '0', STR_PAD_LEFT) . '-' . chr(65 + $i),
                        'model' => 'Mercedes ' . ['70-Seater', '50-Seater', '30-Seater'][$typeIndex],
                        'seat_count' => $seatCounts[$typeIndex],
                        'type' => $vehicleTypes[$typeIndex],
                        'status' => 'active',
                    ]);

                    // Create seats for vehicle
                    $totalSeats = $vehicle->seat_count;
                    $vipSeats = (int)($totalSeats * 0.3); // 30% VIP seats
                    
                    for ($s = 1; $s <= $totalSeats; $s++) {
                        Seat::create([
                            'vehicle_id' => $vehicle->id,
                            'seat_number' => 'S' . str_pad($s, 2, '0', STR_PAD_LEFT),
                            'class' => $s <= $vipSeats ? 'VIP' : 'Normal',
                        ]);
                    }
                }
            }
        }

        // Create Trips for the next 7 days
        $serviceTypes = ['Normal', 'Express', 'VIP'];
        $today = now();
        
        if (Trip::count() === 0 && !empty($routes)) {
            $routesCollection = collect($routes)->values();
            foreach ($routesCollection as $route) {
            // Find agencies in the from_city
                $cityAgencies = Agency::where('city_id', $route->from_city_id)
                    ->where('approval_status', 'approved')
                    ->get();
                
                if ($cityAgencies->isEmpty()) continue;
                
                // Create trips for next 7 days
                for ($day = 0; $day < 7; $day++) {
                    $travelDate = $today->copy()->addDays($day);
                    
                    // Each agency creates 2-3 trips per day on this route
                    foreach ($cityAgencies as $agency) {
                        $tripCount = rand(1, 3);
                        
                        for ($t = 0; $t < $tripCount; $t++) {
                            $serviceType = $serviceTypes[array_rand($serviceTypes)];
                            
                            // Get a vehicle from the company
                            $vehicle = Vehicle::where('company_id', $agency->company_id)
                                ->where('status', 'active')
                                ->inRandomOrder()
                                ->first();
                            
                            if (!$vehicle) continue;
                            
                            // Different departure times
                            $departureHour = 6 + ($t * 4); // 6am, 10am, 2pm
                            $departureTime = sprintf('%02d:00:00', $departureHour);
                            
                            // Calculate arrival time based on route duration
                            $arrivalTime = now()
                                ->setTime($departureHour, 0, 0)
                                ->addMinutes($route->estimated_duration_min)
                                ->format('H:i:s');
                            
                            // Calculate price multiplier based on service type
                            $priceMultiplier = match($serviceType) {
                                'VIP' => 1.5,
                                'Express' => 1.2,
                                default => 1.0
                            };
                            
                            $basePrice = (int)($route->price * $priceMultiplier);
                            
                            $trip = Trip::create([
                                'company_id' => $agency->company_id,
                                'agency_id' => $agency->id,
                                'route_id' => $route->id,
                                'vehicle_id' => $vehicle->id,
                                'travel_date' => $travelDate->format('Y-m-d'),
                                'departure_time' => $departureTime,
                                'arrival_time' => $arrivalTime,
                                'service_type' => $serviceType,
                                'base_price' => $basePrice,
                                'available_seats' => $vehicle->seat_count,
                                'status' => 'scheduled',
                            ]);
                            
                            // Create trip prices
                            TripPrice::create([
                                'trip_id' => $trip->id,
                                'class' => 'Normal',
                                'price' => $basePrice,
                            ]);
                            
                            TripPrice::create([
                                'trip_id' => $trip->id,
                                'class' => 'VIP',
                                'price' => (int)($basePrice * 1.3),
                            ]);
                        }
                    }
                }
            }
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('Cities: ' . City::count());
        $this->command->info('Companies: ' . Company::count());
        $this->command->info('Agencies: ' . Agency::count());
        $this->command->info('Routes: ' . Route::count());
        $this->command->info('Vehicles: ' . Vehicle::count());
        $this->command->info('Trips: ' . Trip::count());

        // Seed presentation-focused schedules/fares for agency profile pages
        $this->call(PresentationAgencyProfileSeeder::class);
        $this->call(AgencyDemoTripsSeeder::class);

        // ============================================
        // Demo accounts for each dashboard
        // ============================================

        $customerRole = Role::where('slug', 'customer')->first();
        $accountantRole = Role::where('slug', 'accountant')->first();
        $counterClerkRole = Role::where('slug', 'counter_clerk')->first();
        $driverRole = Role::where('slug', 'driver')->first();
        $agencyManagerRole = Role::where('slug', 'agency_manager')->first();

        $demoAgency = $agencies[0] ?? Agency::first();

        if ($customerRole) {
            $demoCustomer = User::firstOrCreate(
                ['email' => 'customer.demo@gmail.com'],
                [
                    'full_name' => 'Demo Customer',
                    'phone' => '690000101',
                    'password' => bcrypt('password'),
                    'user_type' => 'customer',
                    'role_id' => $customerRole->id,
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );

            Client::firstOrCreate(
                ['user_id' => $demoCustomer->id],
                [
                    'full_name' => $demoCustomer->full_name,
                    'email' => $demoCustomer->email,
                    'phone' => $demoCustomer->phone,
                    'status' => 'active',
                ]
            );
        }

        if ($agencyManagerRole && $demoAgency) {
            $demoManager = User::firstOrCreate(
                ['email' => 'manager.demo@gmail.com'],
                [
                    'full_name' => 'Demo Agency Manager',
                    'phone' => '690000102',
                    'password' => bcrypt('password'),
                    'user_type' => 'staff',
                    'role_id' => $agencyManagerRole->id,
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );

            $demoAgency->manager_id = $demoManager->id;
            $demoAgency->save();
        }

        if ($accountantRole && $demoAgency) {
            $demoAccountant = User::firstOrCreate(
                ['email' => 'accountant.demo@gmail.com'],
                [
                    'full_name' => 'Demo Accountant',
                    'phone' => '690000103',
                    'password' => bcrypt('password'),
                    'user_type' => 'staff',
                    'role_id' => $accountantRole->id,
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );

            if (Schema::hasColumn('users', 'agency_id')) {
                $demoAccountant->agency_id = $demoAgency->id;
                $demoAccountant->save();
            }

            Employee::firstOrCreate(
                ['user_id' => $demoAccountant->id],
                [
                    'agency_id' => $demoAgency->id,
                    'first_name' => 'Demo',
                    'last_name' => 'Accountant',
                    'position' => 'Accountant',
                    'employee_number' => 'EMP' . str_pad($demoAgency->id, 3, '0', STR_PAD_LEFT) . '-A001',
                    'hire_date' => now()->toDateString(),
                    'base_salary' => 250000,
                    'id_card_number' => 'ID-ACCT-0001',
                ]
            );
        }

        if ($counterClerkRole && $demoAgency) {
            $demoClerk = User::firstOrCreate(
                ['email' => 'clerk.demo@gmail.com'],
                [
                    'full_name' => 'Demo Counter Clerk',
                    'phone' => '690000104',
                    'password' => bcrypt('password'),
                    'user_type' => 'staff',
                    'role_id' => $counterClerkRole->id,
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );

            if (Schema::hasColumn('users', 'agency_id')) {
                $demoClerk->agency_id = $demoAgency->id;
                $demoClerk->save();
            }

            Employee::firstOrCreate(
                ['user_id' => $demoClerk->id],
                [
                    'agency_id' => $demoAgency->id,
                    'first_name' => 'Demo',
                    'last_name' => 'Clerk',
                    'position' => 'Counter Clerk',
                    'employee_number' => 'EMP' . str_pad($demoAgency->id, 3, '0', STR_PAD_LEFT) . '-C001',
                    'hire_date' => now()->toDateString(),
                    'base_salary' => 180000,
                    'id_card_number' => 'ID-CLERK-0001',
                ]
            );
        }

        if ($driverRole && $demoAgency) {
            $demoDriverUser = User::firstOrCreate(
                ['email' => 'driver.demo@gmail.com'],
                [
                    'full_name' => 'Demo Driver',
                    'phone' => '690000105',
                    'password' => bcrypt('password'),
                    'user_type' => 'staff',
                    'role_id' => $driverRole->id,
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );

            if (Schema::hasColumn('users', 'agency_id')) {
                $demoDriverUser->agency_id = $demoAgency->id;
                $demoDriverUser->save();
            }

            $driverEmployee = Employee::firstOrCreate(
                ['user_id' => $demoDriverUser->id],
                [
                    'agency_id' => $demoAgency->id,
                    'first_name' => 'Demo',
                    'last_name' => 'Driver',
                    'position' => 'Driver',
                    'employee_number' => 'EMP' . str_pad($demoAgency->id, 3, '0', STR_PAD_LEFT) . '-D001',
                    'hire_date' => now()->toDateString(),
                    'base_salary' => 200000,
                    'id_card_number' => 'ID-DRIVER-0001',
                ]
            );

            Driver::firstOrCreate(
                ['employee_id' => $driverEmployee->id],
                [
                    'license_number' => 'LIC-DRIVER-0001',
                    'license_category' => 'D',
                    'license_issue_date' => now()->subYears(3)->toDateString(),
                    'license_expiry_date' => now()->addYears(2)->toDateString(),
                    'years_experience' => 3,
                    'status' => 'available',
                ]
            );
        }
    }
}
