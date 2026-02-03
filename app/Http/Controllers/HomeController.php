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
        return view('pages.home');
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