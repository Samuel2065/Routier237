<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\City;
use App\Models\Route;
use App\Models\Trip;
use App\Models\TripPrice;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AgencyDemoTripsSeeder extends Seeder
{
    public function run(): void
    {
        $agencies = Agency::query()
            ->where('approval_status', 'approved')
            ->where('status', 'active')
            ->with(['city', 'company'])
            ->get();

        if ($agencies->isEmpty()) {
            return;
        }

        $citiesBySlug = City::query()
            ->where('status', 'active')
            ->get()
            ->keyBy('slug');

        if ($citiesBySlug->isEmpty()) {
            return;
        }

        $defaultDestinationSlugs = ['douala', 'yaounde', 'bafoussam', 'garoua', 'bertoua', 'bamenda', 'buea'];
        $departureTimes = ['06:30:00', '08:00:00', '12:00:00', '15:10:00'];

        foreach ($agencies as $agency) {
            if (!$agency->city_id || !$agency->company_id) {
                continue;
            }

            $vehicle = Vehicle::query()
                ->where('company_id', $agency->company_id)
                ->where('status', 'active')
                ->first();

            if (!$vehicle) {
                $vehicle = Vehicle::create([
                    'company_id' => $agency->company_id,
                    'plate_number' => 'DEMO-' . str_pad((string) $agency->id, 4, '0', STR_PAD_LEFT),
                    'model' => 'Demo Intercity Coach',
                    'seat_count' => 50,
                    'type' => 'bus',
                    'status' => 'active',
                ]);
            }

            $routes = $this->resolveRoutesForAgency($agency, $citiesBySlug, $defaultDestinationSlugs);
            if ($routes->isEmpty()) {
                continue;
            }

            foreach ($routes as $routeIndex => $route) {
                foreach (range(0, 6) as $dayOffset) {
                    $travelDate = Carbon::today()->addDays($dayOffset)->toDateString();

                    foreach ($departureTimes as $timeIndex => $departureTime) {
                        $isVipTrip = ($timeIndex % 2) === 1;
                        $serviceType = $isVipTrip ? 'VIP' : 'Express';
                        $classicPrice = max((int) ($route->price ?? 2500), 1500);
                        $vipPrice = $classicPrice + max((int) round($classicPrice * 0.30), 1000);
                        $basePrice = $isVipTrip ? $vipPrice : $classicPrice;

                        $durationMinutes = max((int) ($route->estimated_duration_min ?? 180), 60);
                        $arrivalTime = Carbon::createFromFormat('H:i:s', $departureTime)
                            ->addMinutes($durationMinutes)
                            ->format('H:i:s');

                        $trip = Trip::query()->updateOrCreate(
                            [
                                'company_id' => $agency->company_id,
                                'agency_id' => $agency->id,
                                'route_id' => $route->id,
                                'travel_date' => $travelDate,
                                'departure_time' => $departureTime,
                            ],
                            [
                                'vehicle_id' => $vehicle->id,
                                'arrival_time' => $arrivalTime,
                                'service_type' => $serviceType,
                                'base_price' => $basePrice,
                                'available_seats' => max((int) ($vehicle->seat_count ?? 40), 10),
                                'status' => 'scheduled',
                            ]
                        );

                        TripPrice::query()->updateOrCreate(
                            ['trip_id' => $trip->id, 'class' => 'Normal'],
                            ['price' => $classicPrice]
                        );

                        TripPrice::query()->updateOrCreate(
                            ['trip_id' => $trip->id, 'class' => 'VIP'],
                            ['price' => $vipPrice]
                        );
                    }
                }
            }
        }
    }

    private function resolveRoutesForAgency(Agency $agency, $citiesBySlug, array $defaultDestinationSlugs)
    {
        $existingRoutes = Route::query()
            ->where('from_city_id', $agency->city_id)
            ->where('status', 'active')
            ->with(['toCity'])
            ->get();

        $routes = $existingRoutes->take(3)->values();

        if ($routes->count() >= 3) {
            return $routes;
        }

        $fromCity = $agency->city;
        if (!$fromCity) {
            return $routes;
        }

        foreach ($defaultDestinationSlugs as $destinationSlug) {
            $destinationCity = $citiesBySlug->get($destinationSlug);
            if (!$destinationCity || $destinationCity->id === $fromCity->id) {
                continue;
            }

            $route = Route::query()->firstOrCreate(
                [
                    'from_city_id' => $fromCity->id,
                    'to_city_id' => $destinationCity->id,
                ],
                [
                    'distance_km' => $this->estimateDistance($fromCity->id, $destinationCity->id),
                    'estimated_duration_min' => $this->estimateDuration($fromCity->id, $destinationCity->id),
                    'price' => $this->estimateBasePrice($fromCity->id, $destinationCity->id),
                    'status' => 'active',
                ]
            );

            if (!$routes->contains('id', $route->id)) {
                $routes->push($route);
            }

            if ($routes->count() >= 3) {
                break;
            }
        }

        return $routes->values();
    }

    private function estimateDistance(int $fromCityId, int $toCityId): int
    {
        $delta = abs($fromCityId - $toCityId);
        return 120 + ($delta * 35);
    }

    private function estimateDuration(int $fromCityId, int $toCityId): int
    {
        $distance = $this->estimateDistance($fromCityId, $toCityId);
        return max((int) round(($distance / 55) * 60), 90);
    }

    private function estimateBasePrice(int $fromCityId, int $toCityId): int
    {
        $distance = $this->estimateDistance($fromCityId, $toCityId);
        return max((int) round($distance * 12), 1500);
    }
}
