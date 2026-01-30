<?php

namespace Database\Seeders;

use App\Models\{
    Role,
    User,
    Company,
    Agency,
    City,
    Route,
    Trip,
    TripPrice
};

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        /** =====================================================
         * ROLES
         * ===================================================== */
        $directorRole = Role::firstOrCreate(
            ['slug' => 'director'],
            ['name' => 'Director']
        );


        /** =====================================================
         * USERS (DIRECTORS)
         * ===================================================== */
        $director1 = User::firstOrCreate(
            ['email' => 'director1@mail.com'],
            [
                'full_name' => 'Jean Directeur',
                'phone' => '690000001',
                'password' => Hash::make('password'),
                'user_type' => 'staff',
                'role_id' => $directorRole->id,
            ]
        );

        $director2 = User::firstOrCreate(
            ['email' => 'director2@mail.com'],
            [
                'full_name' => 'Paul Directeur',
                'phone' => '690000002',
                'password' => Hash::make('password'),
                'user_type' => 'staff',
                'role_id' => $directorRole->id,
            ]
        );


        /** =====================================================
         * CITIES (safe reseeding)
         * ===================================================== */
        $yaounde = City::firstOrCreate(
            ['slug' => 'yaounde'],
            ['name' => 'Yaoundé', 'region' => 'Centre']
        );

        $douala = City::firstOrCreate(
            ['slug' => 'douala'],
            ['name' => 'Douala', 'region' => 'Littoral']
        );

        $bafoussam = City::firstOrCreate(
            ['slug' => 'bafoussam'],
            ['name' => 'Bafoussam', 'region' => 'Ouest']
        );


        /** =====================================================
         * COMPANIES
         * ===================================================== */
        $company1 = Company::firstOrCreate(
            ['email' => 'overline@mail.com'],
            [
                'name' => 'Overline Transport',
                'phone' => '699000111',
                'headquarters_address' => 'Yaoundé',
                'taxpayer_number' => 'TX001',
                'director_id' => $director1->id,
                'approval_status' => 'approved'
            ]
        );

        $company2 = Company::firstOrCreate(
            ['email' => 'express@mail.com'],
            [
                'name' => 'Express Voyage',
                'phone' => '699000222',
                'headquarters_address' => 'Douala',
                'taxpayer_number' => 'TX002',
                'director_id' => $director2->id,
                'approval_status' => 'approved'
            ]
        );


        /** =====================================================
         * AGENCIES (NO HARDCODED IDS, relationship based)
         * ===================================================== */
        $agencies = [];

        // Overline
        $agencies[] = $yaounde->agencies()->create([
            'company_id' => $company1->id,
            'name' => 'Overline Yaoundé',
            'full_address' => 'Centre Ville',
            'phone' => '677000001',
            'agency_code' => 'OV-YDE',
            'type' => 'main',
            'approval_status' => 'approved'
        ]);

        $agencies[] = $douala->agencies()->create([
            'company_id' => $company1->id,
            'name' => 'Overline Douala',
            'full_address' => 'Akwa',
            'phone' => '677000002',
            'agency_code' => 'OV-DLA',
            'approval_status' => 'approved'
        ]);

        // Express
        $agencies[] = $yaounde->agencies()->create([
            'company_id' => $company2->id,
            'name' => 'Express Yaoundé',
            'full_address' => 'Mokolo',
            'phone' => '677000003',
            'agency_code' => 'EX-YDE',
            'approval_status' => 'approved'
        ]);

        $agencies[] = $douala->agencies()->create([
            'company_id' => $company2->id,
            'name' => 'Express Douala',
            'full_address' => 'Bonapriso',
            'phone' => '677000004',
            'agency_code' => 'EX-DLA',
            'approval_status' => 'approved'
        ]);

        $agencies[] = $bafoussam->agencies()->create([
            'company_id' => $company2->id,
            'name' => 'Express Bafoussam',
            'full_address' => 'Marché A',
            'phone' => '677000005',
            'agency_code' => 'EX-BAF',
            'approval_status' => 'approved'
        ]);


        /** =====================================================
         * ROUTE
         * ===================================================== */
        $route = Route::create([
            'from_city_id' => $yaounde->id,
            'to_city_id' => $douala->id,
            'distance_km' => 240,
            'price' => 3000
        ]);


        /** =====================================================
         * TRIPS + PRICES
         * ===================================================== */
        foreach ($agencies as $agency) {

            $trip = Trip::create([
                'company_id' => $agency->company_id,
                'agency_id' => $agency->id,
                'route_id' => $route->id,
                'travel_date' => now()->addDay(),
                'departure_time' => '07:00',
                'base_price' => 3000,
                'available_seats' => 60,
            ]);

            TripPrice::insert([
                ['trip_id' => $trip->id, 'class' => 'Normal', 'price' => 3000],
                ['trip_id' => $trip->id, 'class' => 'VIP', 'price' => 5000],
            ]);
        }
    }
}
