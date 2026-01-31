<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\City;
use App\Models\Route;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function destinations()
    {
        $cities = City::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('pages.destinations', compact('cities'));
    }

    public function agency()
    {
        return view('pages.agency');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function partner()
    {
        return view('pages.partner');
    }

    public function agency_details()
    {
        return view('pages.agency_details');
    }

    public function view()
    {
        return view('pages.view');
    }

    /**
     * Display marketplace with search form and city listings
     */
    public function marketplace(Request $request)
    {
        // Get all active cities for the search form
        $cities = City::where('status', 'active')
            ->orderBy('name')
            ->get();

        // Get cities with their agency and route counts for the "Choose Your City" section
        $citiesWithStats = City::where('status', 'active')
            ->withCount([
                'agencies' => function ($query) {
                    $query->where('approval_status', 'approved')
                          ->where('status', 'active');
                },
            ])
            ->get()
            ->map(function ($city) {
                // Count unique routes from this city
                $routeCount = Route::where('from_city_id', $city->id)
                    ->where('status', 'active')
                    ->count();
                
                $city->routes_count = $routeCount;
                return $city;
            })
            ->sortByDesc('agencies_count')
            ->take(8);

        return view('pages.marketplace', compact('cities', 'citiesWithStats', 'request'));
    }

    /**
     * Display search results for a specific city
     */
    public function marketplaceCity(Request $request, City $city)
    {
        $from = $request->from;
        $to = $request->to;
        $date = $request->date;
        $serviceType = $request->service_type;

        // Build the query for agencies
        $query = Agency::where('city_id', $city->id)
            ->where('approval_status', 'approved')
            ->where('status', 'active');

        // If search parameters are provided, filter agencies that have matching trips
        if ($from && $to) {
            $query->whereHas('trips', function ($q) use ($from, $to, $serviceType, $date) {
                $q->whereHas('route', function ($routeQuery) use ($from, $to) {
                    $routeQuery->whereHas('fromCity', function ($cityQuery) use ($from) {
                        $cityQuery->where('name', $from);
                    })
                    ->whereHas('toCity', function ($cityQuery) use ($to) {
                        $cityQuery->where('name', $to);
                    });
                });

                if ($date) {
                    $q->whereDate('travel_date', $date);
                }

                if ($serviceType) {
                    $q->where('service_type', $serviceType);
                }

                $q->where('status', 'scheduled');
            });
        }

        // Get agencies with their matching trips
        $agencies = $query->with([
            'company',
            'trips' => function ($q) use ($from, $to, $serviceType, $date) {
                // Load trips with route information
                $q->with([
                    'route.fromCity',
                    'route.toCity',
                    'tripPrices',
                    'vehicle'
                ]);

                // Apply filters if search was performed
                if ($from && $to) {
                    $q->whereHas('route', function ($routeQuery) use ($from, $to) {
                        $routeQuery->whereHas('fromCity', function ($cityQuery) use ($from) {
                            $cityQuery->where('name', $from);
                        })
                        ->whereHas('toCity', function ($cityQuery) use ($to) {
                            $cityQuery->where('name', $to);
                        });
                    });
                }

                if ($date) {
                    $q->whereDate('travel_date', $date);
                }

                if ($serviceType) {
                    $q->where('service_type', $serviceType);
                }

                $q->where('status', 'scheduled')
                  ->orderBy('travel_date')
                  ->orderBy('departure_time')
                  ->limit(5); // Show max 5 trips per agency
            }
        ])
        ->withCount([
            'trips' => function ($q) use ($from, $to, $serviceType, $date) {
                if ($from && $to) {
                    $q->whereHas('route', function ($routeQuery) use ($from, $to) {
                        $routeQuery->whereHas('fromCity', function ($cityQuery) use ($from) {
                            $cityQuery->where('name', $from);
                        })
                        ->whereHas('toCity', function ($cityQuery) use ($to) {
                            $cityQuery->where('name', $to);
                        });
                    });
                }

                if ($date) {
                    $q->whereDate('travel_date', $date);
                }

                if ($serviceType) {
                    $q->where('service_type', $serviceType);
                }

                $q->where('status', 'scheduled');
            }
        ])
        ->paginate(10);

        // Get all cities for potential re-search
        $cities = City::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('pages.marketplace-city', compact(
            'city',
            'agencies',
            'from',
            'to',
            'date',
            'serviceType',
            'cities'
        ));
    }
}
