<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\City;
use App\Models\Company;
use App\Models\Route;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{   

    public function home()
    {
        // ============ GET CITIES FOR SEARCH FORM ============
        $cities = City::where('status', 'active')
            ->orderBy('name')
            ->get();

        // ============ POPULAR ROUTES (3 cards) ============
        $popularRoutes = Route::where('status', 'active')
            ->withCount(['trips' => function($q) {
                $q->where('status', 'scheduled');
            }])
            ->with(['fromCity', 'toCity'])
            ->having('trips_count', '>', 0)
            ->orderByDesc('trips_count')
            ->take(3)
            ->get()
            ->map(function($route) {
                $minPrice = Trip::where('route_id', $route->id)
                    ->where('status', 'scheduled')
                    ->min('base_price') ?? 0;
                
                $travelersPerMonth = $route->trips_count * 30;
                
                $route->min_price = $minPrice;
                $route->travelers_per_month = $travelersPerMonth;
                
                return $route;
            });

        // ============ PARTNER AGENCIES (3 cards) ============
        $partnerAgencies = Company::where('approval_status', 'approved')
            ->where('status', 'active')
            ->withCount(['trips' => function($q) {
                $q->where('status', 'scheduled');
            }])
            ->with(['agencies' => function($q) {
                $q->where('approval_status', 'approved')
                ->where('status', 'active')
                ->with('city')
                ->limit(1);
            }])
            ->having('trips_count', '>', 0)
            ->orderByDesc('trips_count')
            ->take(3)
            ->get()
            ->map(function($company) {
                // Get unique routes for this company
                $routes = Trip::where('company_id', $company->id)
                    ->where('status', 'scheduled')
                    ->with('route.toCity')
                    ->get()
                    ->pluck('route.toCity.name')
                    ->unique()
                    ->take(3)
                    ->values();
                
                $company->unique_routes = $routes;
                $company->main_agency = $company->agencies->first();
                
                // Random rating
                $company->rating = 4.5 + (rand(0, 4) / 10);
                
                // FIXED: Get available services
                $services = Trip::where('company_id', $company->id)
                    ->where('status', 'scheduled')
                    ->distinct()
                    ->pluck('service_type')
                    ->map(function($service) {
                        return $service == 'Normal' ? 'Classic' : $service;
                    })
                    ->values(); // Convert to collection
                
                $company->available_services = $services;
                
                return $company;
            });

        // ============ POPULAR DESTINATIONS (6 cards) ============
        $popularDestinations = City::where('status', 'active')
            ->withCount([
                'agencies' => function($q) {
                    $q->where('approval_status', 'approved')
                    ->where('status', 'active');
                }
            ])
            ->having('agencies_count', '>', 0)
            ->orderByDesc('agencies_count')
            ->take(6)
            ->get()
            ->map(function($city) {
                $routesCount = Route::where('to_city_id', $city->id)
                    ->where('status', 'active')
                    ->count();
                
                $city->routes_count = $routesCount;
                $city->travelers_per_month = $city->agencies_count * 100;
                
                return $city;
            });

        // ============ PERFORMANCE STATS ============
        $totalPartnerAgencies = Agency::where('approval_status', 'approved')
            ->where('status', 'active')
            ->count();
        
        $totalAvailableRoutes = Route::where('status', 'active')
            ->whereHas('trips', function($q) {
                $q->where('status', 'scheduled');
            })
            ->count();

        return view('pages.home', compact(
            'cities',
            'popularRoutes',
            'partnerAgencies', 
            'popularDestinations',
            'totalPartnerAgencies',
            'totalAvailableRoutes'
        ));
    }

    /**
     * Handle search from home page
     */
    public function homeSearch(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        
        // Validate inputs
        if (!$from || !$to) {
            return redirect()->route('home')->with('error', 'Please select both departure city and destination');
        }
        
        // Find the departure city by name to get its slug
        $departureCity = City::where('name', $from)
            ->where('status', 'active')
            ->first();
        
        if (!$departureCity) {
            return redirect()->route('home')->with('error', 'Departure city not found');
        }
        
        // Redirect to marketplace city page with search parameters
        return redirect()->route('marketplace.city', [
            'city' => $departureCity->slug,
            'from' => $from,
            'to' => $to
        ]);
    }

    /**
     * Display destinations page with cities grouped by region
     */
    public function destinations(Request $request)
    {
        $regionFilter = $request->get('region');

        // Get all active cities with their stats
        $query = City::where('status', 'active')
            ->withCount([
                'agencies' => function ($q) {
                    $q->where('approval_status', 'approved')
                      ->where('status', 'active');
                }
            ]);

        // Filter by region if specified
        if ($regionFilter && $regionFilter != 'all') {
            $query->where('region', $regionFilter);
        }

        $cities = $query->get()->map(function ($city) {
            // Count routes from this city
            $routesCount = Route::where('from_city_id', $city->id)
                ->where('status', 'active')
                ->count();

            $city->routes_count = $routesCount;

            // Estimate population based on city (you can adjust these values)
            $populationEstimates = [
                'Douala' => '4M+',
                'Yaoundé' => '3.5M+',
                'Bafoussam' => '450K+',
                'Garoua' => '600K+',
                'Maroua' => '350K+',
                'Bamenda' => '500K+',
                'Buea' => '200K+',
                'Bertoua' => '150K+',
                'Ngaoundéré' => '250K+',
                'Ebolowa' => '120K+',
            ];

            $city->population = $populationEstimates[$city->name] ?? '100K+';

            // Get city description based on name
            $cityDescriptions = [
                'Douala' => 'Economic Capital of Cameroon',
                'Yaoundé' => 'Political Capital of Cameroon',
                'Bafoussam' => 'Gateway to West Region',
                'Garoua' => 'Heart of the North',
                'Maroua' => 'Gateway to the Far North',
                'Bamenda' => 'Capital of Northwest Region',
                'Buea' => 'Mountain City',
                'Bertoua' => 'Gateway to the East',
                'Ngaoundéré' => 'City of Adamawa',
                'Ebolowa' => 'Heart of the South',
            ];

            $city->description = $cityDescriptions[$city->name] ?? 'Beautiful City of Cameroon';

            return $city;
        });

        // Get unique regions for filter
        $regions = City::where('status', 'active')
            ->distinct()
            ->pluck('region')
            ->sort()
            ->values();

        // Calculate total stats
        $totalRegions = $regions->count();
        $totalDestinations = $cities->count();
        $totalAgencies = Agency::where('approval_status', 'approved')
            ->where('status', 'active')
            ->count();

        return view('pages.destinations', compact(
            'cities',
            'regions',
            'regionFilter',
            'totalRegions',
            'totalDestinations',
            'totalAgencies'
        ));
    }


    /**
     * Display all agencies page with filters
     */
    public function agency(Request $request)
    {
        $serviceFilter = $request->get('service');

        // Get all approved companies with their agencies
        $query = Company::where('approval_status', 'approved')
            ->where('status', 'active')
            ->with([
                'agencies' => function($q) {
                    $q->where('approval_status', 'approved')
                      ->where('status', 'active')
                      ->with('city');
                },
                'agencies.trips.route.toCity'
            ]);

        // If service filter is applied, filter companies that have trips with that service
        if ($serviceFilter && $serviceFilter != 'all') {
            $query->whereHas('trips', function($q) use ($serviceFilter) {
                $q->where('service_type', $serviceFilter);
            });
        }

        $companies = $query->get();

        // For each company, calculate:
        // - Available routes (unique destinations)
        // - Available services (unique service types)
        // - Price range
        $companies = $companies->map(function($company) use ($serviceFilter) {
            // Get all trips for this company
            $tripsQuery = Trip::where('company_id', $company->id)
                ->where('status', 'scheduled');

            if ($serviceFilter && $serviceFilter != 'all') {
                $tripsQuery->where('service_type', $serviceFilter);
            }

            $trips = $tripsQuery->with('route.toCity')->get();

            // Get unique destinations
            $destinations = $trips->pluck('route.toCity.name')->unique()->values();
            
            // Get unique services
            $services = Trip::where('company_id', $company->id)
                ->where('status', 'scheduled')
                ->distinct()
                ->pluck('service_type')
                ->map(function($service) {
                    return $service == 'Normal' ? 'Classic' : $service;
                });

            // Get price range
            $minPrice = $trips->min('base_price') ?? 0;
            $maxPrice = $trips->max('base_price') ?? 0;

            // Add computed properties
            $company->destinations = $destinations;
            $company->available_services = $services;
            $company->min_price = $minPrice;
            $company->max_price = $maxPrice;
            $company->main_agency = $company->agencies->first(); // Get first agency for contact info

            return $company;
        })->filter(function($company) {
            // Only keep companies that have at least one destination
            return $company->destinations->count() > 0;
        });

        return view('pages.agency', compact('companies', 'serviceFilter'));
    }

    /**
     * Display agency details page with schedules and fares
     */
    public function agency_details(Request $request, Company $company)
    {
        // Check if company is approved and active
        if ($company->approval_status !== 'approved' || $company->status !== 'active') {
            abort(404);
        }

        // Load company relationships
        $company->load([
            'agencies' => function($q) {
                $q->where('approval_status', 'approved')
                  ->where('status', 'active')
                  ->with('city');
            }
        ]);

        // Get all trips for this company grouped by route
        $tripsGroupedByRoute = Trip::where('company_id', $company->id)
            ->where('status', 'scheduled')
            ->where('travel_date', '>=', now()->format('Y-m-d'))
            ->with([
                'route.fromCity',
                'route.toCity',
                'tripPrices',
                'vehicle',
                'agency'
            ])
            ->orderBy('travel_date')
            ->orderBy('departure_time')
            ->get()
            ->groupBy(function($trip) {
                return $trip->route->fromCity->name . ' → ' . $trip->route->toCity->name;
            });

        // Calculate rating
        $rating = 4.5 + (rand(0, 5) / 10);

        // Get company statistics
        $totalRoutes = Route::whereHas('trips', function($q) use ($company) {
            $q->where('company_id', $company->id)
              ->where('status', 'scheduled');
        })->count();

        $totalTrips = Trip::where('company_id', $company->id)
            ->where('status', 'scheduled')
            ->count();

        // Get customer reviews (dummy data for now - you can implement real reviews later)
        $reviews = [
            [
                'customer_name' => 'Jean Kouam',
                'rating' => 5,
                'comment' => 'Excellent service! Very comfortable journey.',
                'date' => '2 days ago',
            ],
            [
                'customer_name' => 'Marie Fotso',
                'rating' => 4,
                'comment' => 'Good experience, buses are clean and on time.',
                'date' => '1 week ago',
            ],
            [
                'customer_name' => 'Paul Njike',
                'rating' => 5,
                'comment' => 'Professional staff and safe travel. Highly recommended!',
                'date' => '2 weeks ago',
            ],
        ];

        if ($request->boolean('price_alert')) {
            session()->flash('success', 'Price alert set successfully (demo mode).');
        }

        return view('pages.agency_details', compact(
            'company',
            'tripsGroupedByRoute',
            'rating',
            'totalRoutes',
            'totalTrips',
            'reviews'
        ));
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
