<?php

namespace App\Http\Controllers;

use App\Models\TravelPackage;
use App\Models\Agency;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function agency()
    {
        $agencies = Agency::all();
        return view('pages.agency');
    }

    public function contact()
    {
        return view('pages.contact');
    }

     public function dashboard_clients()
    {
        return view('pages.dashboard_clients');
    }

    public function dashboard_agency()
    {
        return view('pages.dashboard_agency');
    }

     public function agency_details()
    {
        return view('pages.agency_details');
    }

    public function destinations()
    {
        return view('pages.destinations');
    }

    public function  marketplace()
    {
        return view('pages.marketplace');
    }   
    
}
