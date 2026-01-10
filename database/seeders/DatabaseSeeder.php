<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agency;
use App\Models\Destination;
use App\Models\Trip;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Créer des destinations
        $destinations = [
            ['name' => 'Gare Routière Yaoundé', 'city' => 'Yaoundé', 'country' => 'Cameroun'],
            ['name' => 'Gare Routière Douala', 'city' => 'Douala', 'country' => 'Cameroun'],
            ['name' => 'Gare Routière Bafoussam', 'city' => 'Bafoussam', 'country' => 'Cameroun'],
            ['name' => 'Gare Routière Bamenda', 'city' => 'Bamenda', 'country' => 'Cameroun'],
        ];

        foreach ($destinations as $dest) {
            Destination::create($dest);
        }

        // Créer des agences
        $agencies = [
            [
                'name' => 'Narral Voyage',
                'description' => 'Transport rapide et sécurisé',
                'phone' => '+237 123 456 789',
                'email' => 'info@garantie-express.com',
                'address' => 'Rue de la République',
                'city' => 'Yaoundé',
                'rating' => 4.5
            ],
            [
                'name' => 'National Voyage',
                'description' => 'Votre partenaire voyage de confiance',
                'phone' => '+237 987 654 321',
                'email' => 'contact@binam-voyage.com',
                'address' => 'Avenue Kennedy',
                'city' => 'Douala',
                'rating' => 4.2
            ]
        ];

        foreach ($agencies as $agency) {
            Agency::create($agency);
        }

        // Create sample trips
        $trips = [
            [
                'agency_id' => 1,
                'departure_town' => 'Yaoundé',
                'arrival_town' => 'Douala',
                'departure_time' => '08:00',
                'departure_date' => now()->addDays(1),
                'price' => 5000
            ],
            [
                'agency_id' => 2,
                'departure_town' => 'Douala',
                'arrival_town' => 'Yaoundé',
                'departure_time' => '09:00',
                'departure_date' => now()->addDays(1),
                'price' => 5000
            ]
        ];

        foreach ($trips as $trip) {
            \App\Models\Trip::create($trip);
        }
    }


}