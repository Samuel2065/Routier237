<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\Route;
use App\Models\Trip;
use App\Models\TripPrice;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class PresentationAgencyProfileSeeder extends Seeder
{
    public function run(): void
    {
        $agencies = Agency::query()
            ->where('approval_status', 'approved')
            ->where('status', 'active')
            ->get();

        if ($agencies->isEmpty()) {
            return;
        }

        foreach ($agencies as $agency) {
            $routes = Route::query()
                ->where('from_city_id', $agency->city_id)
                ->where('status', 'active')
                ->inRandomOrder()
                ->take(3)
                ->get();

            if ($routes->isEmpty()) {
                continue;
            }

            $vehicle = Vehicle::query()
                ->where('company_id', $agency->company_id)
                ->where('status', 'active')
                ->inRandomOrder()
                ->first();

            if (!$vehicle) {
                $vehicle = Vehicle::create([
                    'company_id' => $agency->company_id,
                    'plate_number' => 'PR-' . str_pad((string) $agency->id, 3, '0', STR_PAD_LEFT) . '-' . strtoupper(substr(md5((string) $agency->id), 0, 2)),
                    'model' => 'Presentation Coach',
                    'seat_count' => 50,
                    'type' => 'bus',
                    'status' => 'active',
                ]);
            }

            $routeIndex = 0;
            foreach ($routes as $route) {
                $times = $this->timesForRouteIndex($routeIndex);

                for ($dayOffset = 0; $dayOffset < 4; $dayOffset++) {
                    $travelDate = Carbon::today()->addDays($dayOffset);

                    foreach ($times as $timeIndex => $time) {
                        $routeBasePrice = max((int) ($route->price ?? 2500), 1500);
                        $classicPrice = $routeBasePrice;
                        $vipPrice = $routeBasePrice + max((int) round($routeBasePrice * 0.28), 800);
                        $isVipTrip = $timeIndex % 2 === 1;
                        $serviceType = $isVipTrip ? 'VIP' : 'Express';

                        $arrival = Carbon::createFromFormat('H:i:s', $time)
                            ->addMinutes($route->estimated_duration_min ?? 180)
                            ->format('H:i:s');

                        $trip = Trip::updateOrCreate(
                            [
                                'company_id' => $agency->company_id,
                                'agency_id' => $agency->id,
                                'route_id' => $route->id,
                                'travel_date' => $travelDate->format('Y-m-d'),
                                'departure_time' => $time,
                            ],
                            [
                                'vehicle_id' => $vehicle->id,
                                'arrival_time' => $arrival,
                                'service_type' => $serviceType,
                                'base_price' => $isVipTrip ? $vipPrice : $classicPrice,
                                'available_seats' => max((int) ($vehicle->seat_count ?? 30), 10),
                                'status' => 'scheduled',
                            ]
                        );

                        TripPrice::updateOrCreate(
                            ['trip_id' => $trip->id, 'class' => 'Normal'],
                            ['price' => $classicPrice]
                        );

                        TripPrice::updateOrCreate(
                            ['trip_id' => $trip->id, 'class' => 'VIP'],
                            ['price' => $vipPrice]
                        );
                    }
                }

                $routeIndex++;
            }
        }
    }

    private function timesForRouteIndex(int $routeIndex): Collection
    {
        $templates = [
            ['06:30:00', '08:00:00', '12:00:00', '15:10:00'],
            ['07:00:00', '09:30:00', '14:00:00', '17:00:00'],
            ['06:00:00', '10:00:00', '14:30:00', '19:00:00'],
        ];

        return collect($templates[$routeIndex % count($templates)]);
    }
}
