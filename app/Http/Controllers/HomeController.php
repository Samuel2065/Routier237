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
        // Get all active cities with their images
        $cities = City::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('pages.destinations', compact('cities'));
    }

    public function agency()
    {
        return view('pages.agency');
    }

    public function signup()
    {
        return view('pages.sign_up');
    }  
    
    public function signin()
    {
        return view('pages.sign_in');
    }   

   
    public function marketplace()
    {
        $cities = City::where('status', 'active')->orderBy('name')->get();

        return view('pages.marketplace', compact('cities'));
    }

    public function marketplaceCity(Request $request, City $city)
{
    $from = $request->from;
    $to = $request->to;
    $date = $request->date;
    $service = $request->service_type;

    $agencies = Agency::where('city_id', $city->id)

        ->whereHas('trips', function ($q) use ($from, $to, $service, $date) {

            $q->whereHas('route.fromCity', fn($c) =>
                $c->where('name', $from)
            )
            ->whereHas('route.toCity', fn($c) =>
                $c->where('name', $to)
            );

            if ($date) {
                $q->whereDate('travel_date', $date);
            }

            if ($service) {
                $q->where('service_type', $service);
            }
        })

        ->with(['trips' => function ($q) use ($from, $to, $service, $date) {

            $q->whereHas('route.fromCity', fn($c) =>
                $c->where('name', $from)
            )
            ->whereHas('route.toCity', fn($c) =>
                $c->where('name', $to)
            );

            if ($date) {
                $q->whereDate('travel_date', $date);
            }

            if ($service) {
                $q->where('service_type', $service);
            }

            $q->with('route.fromCity', 'route.toCity');
        }])

        ->get();

    return view('marketplace.city-results', compact(
        'city', 'agencies', 'from', 'to', 'date', 'service'
    ));
}



}

