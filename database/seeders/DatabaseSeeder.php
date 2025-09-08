<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agency;
use App\Models\Destination;
use App\Models\Route;
use App\Models\Schedule;
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
                'name' => 'Garantie Express',
                'description' => 'Transport rapide et sécurisé',
                'phone' => '+237 123 456 789',
                'email' => 'info@garantie-express.com',
                'address' => 'Rue de la République',
                'city' => 'Yaoundé',
                'rating' => 4.5
            ],
            [
                'name' => 'Binam Voyage',
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

        // Créer des trajets et horaires
        $this->createSampleRoutes();
    }

    private function createSampleRoutes()
    {
        $agency1 = Agency::first();
        $agency2 = Agency::find(2);
        
        $routes = [
            [
                'agency_id' => $agency1->id,
                'departure_destination_id' => 1,
                'arrival_destination_id' => 2,
                'departure_time' => '08:00',
                'arrival_time' => '12:00',
                'price' => 5000,
                'available_seats' => 45,
                'total_seats' => 50,
                'bus_type' => 'vip',
                'amenities' => ['climatisation', 'wifi', 'television']
            ]
        ];

        foreach ($routes as $routeData) {
            $route = Route::create($routeData);
            
            // Créer des horaires pour les 30 prochains jours
            for ($i = 0; $i < 30; $i++) {
                Schedule::create([
                    'route_id' => $route->id,
                    'travel_date' => Carbon::today()->addDays($i),
                    'available_seats' => $routeData['available_seats'],
                    'current_price' => $routeData['price'],
                    'is_available' => true
                ]);
            }
        }
    }
}