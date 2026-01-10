<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Route;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;

class DashboardDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test agency
        $agency = User::create([
            'user_type' => 'agency',
            'name' => 'John Manager',
            'email' => 'agency@test.com',
            'phone' => '677123456',
            'password' => Hash::make('password'),
            'agency_name' => 'Express Voyages',
            'business_license' => 'BL-2024-001',
            'address' => 'Yaoundé, Cameroon',
            'tax_id' => 'TX-123456',
            'contact_person' => 'John Manager',
        ]);

        // Create a test passenger
        $passenger = User::create([
            'user_type' => 'passenger',
            'name' => 'Marie Kamga',
            'email' => 'passenger@test.com',
            'phone' => '677654321',
            'password' => Hash::make('password'),
        ]);

        // Create some routes
        $route1 = Route::create([
            'agency_id' => $agency->id,
            'departure_city' => 'Yaoundé',
            'arrival_city' => 'Douala',
            'departure_date' => now()->addDays(1),
            'departure_time' => '06:00:00',
            'price' => 5000,
            'total_seats' => 50,
            'available_seats' => 45,
            'status' => 'active',
        ]);

        $route2 = Route::create([
            'agency_id' => $agency->id,
            'departure_city' => 'Douala',
            'arrival_city' => 'Bafoussam',
            'departure_date' => now(),
            'departure_time' => '08:30:00',
            'price' => 7500,
            'total_seats' => 50,
            'available_seats' => 0,
            'status' => 'full',
        ]);

        // Create some bookings
        Booking::create([
            'user_id' => $passenger->id,
            'route_id' => $route1->id,
            'passenger_name' => 'Marie Kamga',
            'passenger_phone' => '677654321',
            'seat_number' => '12A',
            'amount_paid' => 5000,
            'status' => 'confirmed',
            'payment_status' => 'paid',
        ]);
    }
}